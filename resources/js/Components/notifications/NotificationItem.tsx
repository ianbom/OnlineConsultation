import { cn } from '@/lib/utils';
import { formatDistanceToNow } from 'date-fns';
import { Bell, CreditCard, Gift, Info } from 'lucide-react';

interface NotificationItemProps {
    type: 'reminder' | 'payment' | 'system' | 'promo';
    title: string;
    message: string;
    timestamp: string;
    isRead: boolean;
}

const typeIcons = {
    reminder: Bell,
    payment: CreditCard,
    system: Info,
    promo: Gift,
};

const typeColors = {
    reminder: 'text-info bg-info/10',
    payment: 'text-warning bg-warning/10',
    system: 'text-muted-foreground bg-muted',
    promo: 'text-accent bg-accent/10',
};

export function NotificationItem({
    type,
    title,
    message,
    timestamp,
    isRead,
}: NotificationItemProps) {
    const Icon = typeIcons[type];
    const colorClass = typeColors[type];

    return (
        <div
            className={cn(
                'flex gap-3 rounded-lg p-3 transition-colors',
                isRead ? 'bg-transparent' : 'bg-secondary/50',
            )}
        >
            <div
                className={cn(
                    'flex h-9 w-9 shrink-0 items-center justify-center rounded-full',
                    colorClass,
                )}
            >
                <Icon className="h-4 w-4" />
            </div>
            <div className="min-w-0 flex-1">
                <div className="flex items-start justify-between gap-2">
                    <h4
                        className={cn(
                            'text-sm font-medium',
                            !isRead && 'text-foreground',
                        )}
                    >
                        {title}
                    </h4>
                    {!isRead && (
                        <span className="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-primary" />
                    )}
                </div>
                <p className="mt-0.5 line-clamp-2 text-sm text-muted-foreground">
                    {message}
                </p>
                <p className="mt-1 text-xs text-muted-foreground">
                    {formatDistanceToNow(new Date(timestamp), {
                        addSuffix: true,
                    })}
                </p>
            </div>
        </div>
    );
}
