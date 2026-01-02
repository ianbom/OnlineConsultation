import { useToast } from '@/hooks/use-toast';
import { usePage } from '@inertiajs/react';
import { ReactNode, useEffect } from 'react';
import { Toaster } from '../ui/toaster';
import { Footer } from './Footer';
import { Header } from './Header';
import WAIcon from './WAIcon';

interface PageLayoutProps {
    children: ReactNode;
    title?: string;
    description?: string;
}

interface FlashMessages {
    success?: string;
    error?: string;
    warning?: string;
    info?: string;
}

interface PageProps {
    auth: {
        user: {
            id: number;
            name: string;
            email: string;
            [key: string]: unknown;
        };
    };
    flash: FlashMessages;
    [key: string]: unknown;
}

export function PageLayout({ children, title, description }: PageLayoutProps) {
    const { flash } = usePage<PageProps>().props;
    const { toast } = useToast();

    useEffect(() => {
        // Handle success message
        if (flash?.success) {
            toast({
                title: 'Berhasil',
                description: flash.success,
                variant: 'default', // hijau
            });
        }

        // Handle error message
        if (flash?.error) {
            toast({
                title: 'Error',
                description: flash.error,
                variant: 'destructive', // merah
            });
        }

        // Handle warning message
        if (flash?.warning) {
            toast({
                title: 'Peringatan',
                description: flash.warning,
                variant: 'warning', // kuning
            });
        }

        // Handle info message
        if (flash?.info) {
            toast({
                title: 'Informasi',
                description: flash.info,
                variant: 'info', // biru
            });
        }
    }, [flash, toast]);

    return (
        <div className="flex min-h-screen flex-col bg-background">
            <Header />
            <main className="mx-auto w-full max-w-screen-xl flex-1 px-4 py-6 md:px-6 md:py-8">
                {(title || description) && (
                    <div className="mb-6 md:mb-8">
                        {title && (
                            <h1 className="font-display text-2xl font-semibold text-foreground md:text-3xl">
                                {title}
                            </h1>
                        )}
                        {description && (
                            <p className="mt-1 text-muted-foreground">
                                {description}
                            </p>
                        )}
                    </div>
                )}
                {children}
            </main>
            <Footer />
            <WAIcon />
            <Toaster />
        </div>
    );
}
