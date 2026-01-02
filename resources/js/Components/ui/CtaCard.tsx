import { Button } from '@/Components/ui/button';
import { Card, CardContent } from '@/Components/ui/card';
import { Link } from '@inertiajs/react';
import { Users } from 'lucide-react';

export function CtaCard() {
    return (
        <Card className="relative overflow-hidden rounded-2xl border-0">
            {/* Background Image */}
            <div
                className="absolute inset-0 bg-cover bg-center"
                style={{
                    backgroundImage:
                        "url('https://images.unsplash.com/photo-1581578731548-c64695cc6952?auto=format&fit=crop&w=1600&q=80')",
                }}
            />

            {/* Dark Overlay */}
            <div className="absolute inset-0 bg-black/60" />

            <CardContent className="relative z-10 flex flex-col items-start justify-between gap-6 p-6 md:flex-row md:items-center md:p-10">
                {/* LEFT CONTENT */}
                <div className="max-w-xl">
                    <h2 className="text-2xl font-bold leading-tight text-white md:text-3xl">
                        Konseling yang Menyesuaikan Kebutuhan Anda
                    </h2>
                    <p className="mt-2 text-sm text-white/80 md:text-base">
                        Temukan konselor profesional dan jadwalkan sesi dengan
                        mudah, kapan pun Anda membutuhkannya.
                    </p>
                </div>

                {/* CTA BUTTON */}
                <Button
                    size="lg"
                    className="bg-yellow-400 px-6 font-semibold text-black hover:bg-yellow-500"
                    asChild
                >
                    <Link href="/client/list-counselors">
                        <Users className="mr-2 h-5 w-5" />
                        Cari Konselor
                    </Link>
                </Button>
            </CardContent>
        </Card>
    );
}
