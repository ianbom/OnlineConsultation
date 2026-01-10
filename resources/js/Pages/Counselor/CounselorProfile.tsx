import { PageLayout } from '@/Components/layout/PageLayout';
import { Avatar, AvatarFallback, AvatarImage } from '@/Components/ui/avatar';
import { Badge } from '@/Components/ui/badge';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Counselor } from '@/Interfaces';
import { getProfilePicUrl } from '@/utils/booking';
import { Link } from '@inertiajs/react';
import {
    Briefcase,
    Calendar,
    ChevronLeft,
    Clock,
    GraduationCap,
} from 'lucide-react';

const dayNames = [
    'monday',
    'tuesday',
    'wednesday',
    'thursday',
    'friday',
    'saturday',
    'sunday',
];
const dayLabels: Record<string, string> = {
    monday: 'Senin',
    tuesday: 'Selasa',
    wednesday: 'Rabu',
    thursday: 'Kamis',
    friday: 'Jumat',
    saturday: 'Sabtu',
    sunday: 'Minggu',
};

interface Props {
    counselor: Counselor;
}

export default function CounselorProfile({ counselor }: Props) {
    const specializations = counselor.specialization
        .split(',')
        .map((s) => s.trim());

    const educationList = [counselor.education];

    // Hitung ketersediaan berdasarkan work_days
    const availabilityByDay = dayNames.reduce(
        (acc, day) => {
            // Cek apakah ada workDay aktif untuk hari ini
            const workDay = counselor.work_days?.find(
                (wd) => wd.day_of_week.toLowerCase() === day && wd.is_active,
            );

            // Jika workDay ditemukan dan aktif, tandai sebagai tersedia
            acc[day] = workDay ? 1 : 0;

            return acc;
        },
        {} as Record<string, number>,
    );

    const profilePicUrl = getProfilePicUrl(counselor.user.profile_pic);

    const isAvailable = counselor.status === 'active';

    console.log(availabilityByDay);
    console.log(isAvailable);

    return (
        <PageLayout>
            <div className="mx-auto max-w-4xl">
                {/* Tombol Kembali */}
                <Button variant="ghost" asChild className="mb-4">
                    <Link href={route('client.counselor.list')}>
                        <ChevronLeft className="mr-1 h-4 w-4" />
                        Kembali ke Daftar Konselor
                    </Link>
                </Button>

                {/* Header Profil */}
                <Card className="mb-6 overflow-hidden">
                    <div className="gradient-primary h-24" />
                    <CardContent className="relative pb-6 pt-0">
                        <div className="-mt-12 flex flex-col gap-4 sm:flex-row sm:items-end">
                            {/* Foto Profil */}
                            <Avatar className="h-24 w-24 rounded-xl border-4 border-card">
                                <AvatarImage
                                    src={profilePicUrl}
                                    alt={counselor.user.name}
                                    className="object-cover"
                                />
                                <AvatarFallback className="rounded-xl text-2xl">
                                    {counselor.user.name
                                        .split(' ')
                                        .map((n) => n[0])
                                        .join('')}
                                </AvatarFallback>
                            </Avatar>

                            {/* Nama & Status */}
                            <div className="flex-1">
                                <div className="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
                                    <h1 className="font-display text-2xl font-semibold text-foreground">
                                        {counselor.user.name}
                                    </h1>

                                    <Badge
                                        variant={
                                            isAvailable
                                                ? 'success'
                                                : 'secondary'
                                        }
                                        className="inline-flex w-fit self-start whitespace-nowrap px-2.5 py-0.5 text-xs sm:self-auto"
                                    >
                                        {isAvailable
                                            ? 'Tersedia'
                                            : 'Tidak Tersedia'}
                                    </Badge>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <div className="grid gap-6 md:grid-cols-3">
                    {/* Konten Utama */}
                    <div className="space-y-6 md:col-span-2">
                        {/* Tentang Konselor */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="text-lg">
                                    Tentang Konselor
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <p className="leading-relaxed text-muted-foreground">
                                    {counselor.description}
                                </p>

                                <div className="mt-4 flex flex-wrap gap-2">
                                    {specializations.map((spec) => (
                                        <Badge key={spec} variant="secondary">
                                            {spec}
                                        </Badge>
                                    ))}
                                </div>
                            </CardContent>
                        </Card>

                        {/* Pendidikan */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center gap-2 text-lg">
                                    <GraduationCap className="h-5 w-5 text-primary" />
                                    Pendidikan
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <ul className="space-y-2">
                                    {educationList.map((edu, index) => (
                                        <li
                                            key={index}
                                            className="flex items-start gap-2 text-muted-foreground"
                                        >
                                            <span className="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-primary" />
                                            {edu}
                                        </li>
                                    ))}
                                </ul>
                            </CardContent>
                        </Card>

                        {/* Pengalaman */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center gap-2 text-lg">
                                    <Briefcase className="h-5 w-5 text-primary" />
                                    Pengalaman
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <p className="flex items-start gap-2 text-muted-foreground">
                                    <span className="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-primary" />
                                    Konselor profesional dengan spesialisasi
                                    dalam {specializations.join(', ')}
                                </p>
                            </CardContent>
                        </Card>
                    </div>

                    {/* Sidebar */}
                    <div className="space-y-6">
                        {/* Ketersediaan */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center gap-2 text-lg">
                                    <Calendar className="h-5 w-5 text-primary" />
                                    Ketersediaan Jadwal
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="space-y-3">
                                    {dayNames.map((day) => {
                                        const slots =
                                            availabilityByDay[day] || 0;
                                        const isAvailableDay = slots > 0;
                                        return (
                                            <div
                                                key={day}
                                                className="flex items-center justify-between text-sm"
                                            >
                                                <span className="font-medium text-foreground">
                                                    {dayLabels[day]}
                                                </span>
                                                <span
                                                    className={`font-medium ${isAvailableDay ? 'text-green-600' : 'text-red-500'}`}
                                                >
                                                    {isAvailableDay
                                                        ? 'Tersedia'
                                                        : 'Tidak tersedia'}
                                                </span>
                                            </div>
                                        );
                                    })}
                                </div>
                            </CardContent>
                        </Card>

                        {/* Booking CTA */}
                        <Card className="border-primary/20 bg-primary/5">
                            <CardContent className="space-y-4 p-5">
                                <div className="flex items-center gap-2 text-foreground">
                                    <Clock className="h-5 w-5 text-primary" />
                                    <span className="font-medium">
                                        Durasi sesi 60 menit
                                    </span>
                                </div>

                                <div>
                                    <div className="text-xl font-semibold text-foreground">
                                        Rp{' '}
                                        {counselor.price_per_session.toLocaleString(
                                            'id-ID',
                                        )}
                                        <span className="text-sm font-normal text-muted-foreground">
                                            {' '}/offline
                                        </span>
                                    </div>
                                    <div className="text-lg font-medium text-green-600">
                                        Rp{' '}
                                        {counselor.online_price_per_session.toLocaleString(
                                            'id-ID',
                                        )}
                                        <span className="text-sm font-normal text-muted-foreground">
                                            {' '}/online
                                        </span>
                                    </div>
                                </div>

                                <div className="space-y-2">
                                    <Button
                                        className="w-full"
                                        size="lg"
                                        asChild
                                    >
                                        <Link
                                            href={route(
                                                'client.pick.schedule',
                                                counselor.id,
                                            )}
                                        >
                                            Pilih Jadwal
                                        </Link>
                                    </Button>
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </PageLayout>
    );
}
