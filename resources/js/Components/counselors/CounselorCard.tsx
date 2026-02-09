import { Avatar, AvatarFallback, AvatarImage } from '@/Components/ui/avatar';
import { Badge } from '@/Components/ui/badge';
import { Button } from '@/Components/ui/button';
import { Card, CardContent } from '@/Components/ui/card';
import { getProfilePicUrl } from '@/utils/booking';
import { Link } from '@inertiajs/react';

interface CounselorCardProps {
    id: string;
    name: string;
    photo: string;
    specializations: string[];
    pricePerSession: number;
    isAvailable: boolean;
}

export function CounselorCard({
    id,
    name,
    photo,
    specializations,
    pricePerSession,
    isAvailable,
}: CounselorCardProps) {
    const photoUrl = getProfilePicUrl(photo || null);

    return (
        <Card className="rounded-xl border transition-all duration-200 hover:shadow-md">
            <CardContent className="p-4">
                {/* Top Section */}
                <div className="flex items-center gap-3">
                    <Avatar className="h-12 w-12 rounded-lg border">
                        <AvatarImage
                            src={photoUrl}
                            alt={name}
                            className="object-cover"
                        />
                        <AvatarFallback className="rounded-lg bg-primary/10 text-sm font-medium text-primary">
                            {name
                                .split(',')
                                .map((n) => n.trim()[0])
                                .join('')}
                        </AvatarFallback>
                    </Avatar>

                    <div className="min-w-0 flex-1">
                        <h3 className="truncate text-sm font-semibold text-foreground">
                            {name}
                        </h3>
                    </div>

                    <Badge
                        variant={isAvailable ? 'success' : 'destructive'}
                        className="px-2 py-0.5 text-[10px]"
                    >
                        {isAvailable ? 'Active' : 'Inactive'}
                    </Badge>
                </div>

                {/* Specializations */}
                <div className="mt-3 flex flex-wrap gap-1">
                    {specializations.slice(0, 2).map((spec) => (
                        <Badge
                            key={spec}
                            variant="secondary"
                            className="whitespace-nowrap px-2 py-0.5 text-[10px]"
                        >
                            {spec.replace(/,/g, '')}
                        </Badge>
                    ))}

                    {specializations.length > 2 && (
                        <Badge
                            variant="outline"
                            className="px-2 py-0.5 text-[10px]"
                        >
                            +{specializations.length - 2}
                        </Badge>
                    )}
                </div>

                {/* Bottom Section */}
                <div className="mt-4 flex items-center justify-between">
                    <div>
                        <span className="block text-sm text-muted-foreground">
                            Fee
                        </span>
                        <span className="text-lg font-semibold text-primary">
                            Rp{pricePerSession.toLocaleString('id-ID')}
                        </span>
                    </div>

                    {isAvailable ? (
                        <Button
                            asChild
                            size="sm"
                            className="h-7 bg-primary px-3 py-1 text-xs hover:bg-primary/80"
                        >
                            <Link href={route('client.counselor.show', id)}>
                                Pesan Konsultasi
                            </Link>
                        </Button>
                    ) : (
                        <Button
                            size="sm"
                            disabled
                            className="h-7 px-3 py-1 text-xs"
                        >
                            Tidak Tersedia
                        </Button>
                    )}
                </div>
            </CardContent>
        </Card>
    );
}
