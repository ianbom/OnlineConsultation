import { cn } from '@/lib/utils';
import { AlertCircle, Calendar, FileX, Search } from 'lucide-react';

interface EmptyStateProps {
    icon?: 'search' | 'calendar' | 'file' | 'alert';
    title: string;
    description?: string;
    action?: React.ReactNode;
    className?: string;
}

const icons = {
    search: Search,
    calendar: Calendar,
    file: FileX,
    alert: AlertCircle,
};

export function EmptyState({
    icon = 'file',
    title,
    description,
    action,
    className,
}: EmptyStateProps) {
    const Icon = icons[icon];

    return (
        <div
            className={cn(
                'flex flex-col items-center justify-center px-4 py-12 text-center',
                className,
            )}
        >
            <div className="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-muted">
                <Icon className="h-8 w-8 text-muted-foreground" />
            </div>
            <h3 className="mb-1 font-display text-lg font-semibold text-foreground">
                {title}
            </h3>
            {description && (
                <p className="mb-4 max-w-sm text-sm text-muted-foreground">
                    {description}
                </p>
            )}
            {action}
        </div>
    );
}
