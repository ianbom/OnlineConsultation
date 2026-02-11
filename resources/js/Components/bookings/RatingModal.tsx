import { Button } from '@/Components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/Components/ui/dialog';
import { Textarea } from '@/Components/ui/textarea';
import { Booking } from '@/Interfaces';
import { router } from '@inertiajs/react';
import { Star } from 'lucide-react';
import { useState } from 'react';

interface Props {
    booking: Booking;
}

export default function RatingModal({ booking }: Props) {
    const existingRating = booking.rating;
    const isEditing = !!existingRating;

    const [open, setOpen] = useState(false);
    const [rating, setRating] = useState(existingRating?.rating ?? 0);
    const [hoveredRating, setHoveredRating] = useState(0);
    const [commentar, setCommentar] = useState(
        existingRating?.commentar ?? '',
    );
    const [isSubmitting, setIsSubmitting] = useState(false);

    const handleSubmit = () => {
        if (rating === 0) return;

        setIsSubmitting(true);

        if (isEditing && existingRating) {
            router.put(
                route('client.rating.update', existingRating.id),
                { rating, commentar },
                {
                    preserveScroll: true,
                    onSuccess: () => setOpen(false),
                    onFinish: () => setIsSubmitting(false),
                },
            );
        } else {
            router.post(
                route('client.rating.store'),
                { booking_id: booking.id, rating, commentar },
                {
                    preserveScroll: true,
                    onSuccess: () => setOpen(false),
                    onFinish: () => setIsSubmitting(false),
                },
            );
        }
    };

    const displayRating = hoveredRating || rating;

    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <DialogTrigger asChild>
                <Button
                    variant={isEditing ? 'outline' : 'default'}
                    className={
                        isEditing
                            ? 'my-2 w-full gap-2'
                            : 'my-2 w-full gap-2 bg-yellow-500 hover:bg-yellow-600'
                    }
                >
                    <Star className="h-4 w-4" />
                    {isEditing ? 'Ubah Rating' : 'Beri Rating'}
                </Button>
            </DialogTrigger>

            <DialogContent className="sm:max-w-md">
                <DialogHeader>
                    <DialogTitle>
                        {isEditing
                            ? 'Ubah Rating Konselor'
                            : 'Beri Rating Konselor'}
                    </DialogTitle>
                    <DialogDescription>
                        {isEditing
                            ? 'Perbarui penilaian Anda terhadap sesi konseling ini.'
                            : 'Berikan penilaian Anda terhadap sesi konseling ini.'}
                    </DialogDescription>
                </DialogHeader>

                <div className="space-y-4 py-2">
                    <div>
                        <p className="mb-2 text-sm font-medium">Rating</p>
                        <div className="flex items-center gap-1">
                            {[1, 2, 3, 4, 5].map((star) => (
                                <button
                                    key={star}
                                    type="button"
                                    onClick={() => setRating(star)}
                                    onMouseEnter={() =>
                                        setHoveredRating(star)
                                    }
                                    onMouseLeave={() => setHoveredRating(0)}
                                    className="rounded-sm p-1 transition-transform hover:scale-110"
                                >
                                    <Star
                                        className={`h-8 w-8 transition-colors ${star <= displayRating
                                                ? 'fill-yellow-400 text-yellow-400'
                                                : 'text-muted-foreground/30'
                                            }`}
                                    />
                                </button>
                            ))}
                        </div>
                        {rating > 0 && (
                            <p className="mt-1 text-sm text-muted-foreground">
                                {rating === 1 && 'Kurang Baik'}
                                {rating === 2 && 'Cukup'}
                                {rating === 3 && 'Baik'}
                                {rating === 4 && 'Sangat Baik'}
                                {rating === 5 && 'Luar Biasa'}
                            </p>
                        )}
                    </div>

                    <div>
                        <p className="mb-2 text-sm font-medium">
                            Komentar{' '}
                            <span className="text-muted-foreground">
                                (opsional)
                            </span>
                        </p>
                        <Textarea
                            value={commentar}
                            onChange={(e) => setCommentar(e.target.value)}
                            placeholder="Ceritakan pengalaman Anda selama sesi konseling..."
                            rows={4}
                            maxLength={1000}
                        />
                        <p className="mt-1 text-right text-xs text-muted-foreground">
                            {commentar.length}/1000
                        </p>
                    </div>
                </div>

                <DialogFooter>
                    <Button
                        variant="outline"
                        onClick={() => setOpen(false)}
                        disabled={isSubmitting}
                    >
                        Batal
                    </Button>
                    <Button
                        onClick={handleSubmit}
                        disabled={rating === 0 || isSubmitting}
                    >
                        {isSubmitting
                            ? 'Menyimpan...'
                            : isEditing
                                ? 'Perbarui Rating'
                                : 'Kirim Rating'}
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
}
