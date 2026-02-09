import { Avatar, AvatarFallback, AvatarImage } from '@/Components/ui/avatar';
import { Button } from '@/Components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu';
import { cn } from '@/lib/utils';
import { Link, router, usePage } from '@inertiajs/react';
import {
    Calendar,
    HelpCircle,
    LayoutDashboard,
    Menu,
    User,
    Users,
    X,
} from 'lucide-react';
import { useState } from 'react';

const navItems = [
    { path: '/client/dashboard', label: 'Dashboard', icon: LayoutDashboard },
    { path: '/client/list-counselors', label: 'Counselors', icon: Users },
    { path: '/client/booking-history', label: 'My Bookings', icon: Calendar },
    { path: '/client/my-profile', label: 'Profile', icon: User },
    { path: '/client/faq', label: 'FAQ', icon: HelpCircle },
];

interface User {
    id: number;
    name: string;
    email: string;

    // tambahkan ini:
    profile_pic?: string | null;
    role?: string;
    phone?: string | null;

    // field lain sesuai share()
}

export function Header() {
    const { url, props } = usePage();
    const user = props.auth.user as User;

    const pathname = url.split('?')[0];
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

    const handleLogout = () => {
        router.post(route('logout'));
    };

    return (
        <header className="sticky top-0 z-50 w-full border-b bg-card/80 backdrop-blur-md">
            <div className="mx-auto flex h-16 max-w-screen-xl items-center justify-between px-4 md:px-6">
                <Link href="/" className="flex items-center gap-2">
                    <div className="flex h-12 w-12 items-center justify-center overflow-hidden rounded-lg">
                        <img
                            src={'/LogoPqNew.png'}
                            alt="PersonaQuality Logo"
                            className="h-12 w-12 object-contain"
                        />
                    </div>

                    <span className="font-display text-lg font-medium text-foreground">
                        PersonaQuality
                    </span>
                </Link>

                {/* Desktop Navigation */}
                <nav className="hidden items-center gap-1 md:flex">
                    {navItems.map((item) => {
                        const isActive = pathname === item.path;
                        return (
                            <Link
                                key={item.path}
                                href={item.path}
                                className={cn(
                                    'flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium transition-colors',
                                    isActive
                                        ? 'bg-primary text-primary-foreground'
                                        : 'text-muted-foreground hover:bg-secondary hover:text-foreground',
                                )}
                            >
                                <item.icon className="h-4 w-4" />
                                {item.label}
                            </Link>
                        );
                    })}
                </nav>

                {/* Right Actions */}
                <div className="flex items-center gap-3">
                    {/* <Button variant="ghost" size="icon" className="relative">
            <Bell className="h-5 w-5" />
            <span className="absolute top-1 right-1 h-2 w-2 rounded-full bg-accent" />
          </Button> */}

                    <DropdownMenu>
                        <DropdownMenuTrigger className="hidden focus:outline-none md:block">
                            <Avatar className="h-9 w-9 cursor-pointer border-2 border-primary/20">
                                <AvatarImage
                                    src={
                                        user?.profile_pic
                                            ? `/storage/${user.profile_pic}`
                                            : '/default-avatar.png'
                                    }
                                />
                                <AvatarFallback>
                                    {user?.name
                                        ?.split(' ')
                                        .map((n) => n[0])
                                        .join('')
                                        .toUpperCase()}
                                </AvatarFallback>
                            </Avatar>
                        </DropdownMenuTrigger>

                        <DropdownMenuContent align="end" className="w-48">
                            <DropdownMenuLabel className="text-sm">
                                {user?.name}
                            </DropdownMenuLabel>

                            <DropdownMenuSeparator />

                            <DropdownMenuItem asChild>
                                <Link href="/client/my-profile">Profile</Link>
                            </DropdownMenuItem>

                            <DropdownMenuSeparator />

                            <DropdownMenuItem
                                onClick={handleLogout}
                                className="cursor-pointer text-red-600"
                            >
                                Logout
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>

                    {/* Mobile Menu Button */}
                    <Button
                        variant="ghost"
                        size="icon"
                        className="md:hidden"
                        onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                    >
                        {mobileMenuOpen ? (
                            <X className="h-5 w-5" />
                        ) : (
                            <Menu className="h-5 w-5" />
                        )}
                    </Button>
                </div>
            </div>

            {/* Mobile Navigation */}
            {mobileMenuOpen && (
                <nav className="animate-fade-in border-t bg-card p-4 md:hidden">
                    <div className="mx-auto flex max-w-screen-xl flex-col gap-2 px-4">
                        {navItems.map((item) => {
                            const isActive = pathname === item.path;
                            return (
                                <Link
                                    key={item.path}
                                    href={item.path}
                                    onClick={() => setMobileMenuOpen(false)}
                                    className={cn(
                                        'flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition-colors',
                                        isActive
                                            ? 'bg-primary text-primary-foreground'
                                            : 'text-muted-foreground hover:bg-secondary hover:text-foreground',
                                    )}
                                >
                                    <item.icon className="h-5 w-5" />
                                    {item.label}
                                </Link>
                            );
                        })}
                    </div>
                </nav>
            )}
        </header>
    );
}
