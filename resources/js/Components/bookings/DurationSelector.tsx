import { Clock } from 'lucide-react';

interface DurationSelectorProps {
    duration: 1 | 2;
    onChange: (hours: 1 | 2) => void;
    locked: boolean;
}

export const DurationSelector: React.FC<DurationSelectorProps> = ({
    duration,
    onChange,
    locked,
}) => {
    const options = [
        { hours: 1 as const, label: '1 Jam', sublabel: 'Sesi standar' },
        { hours: 2 as const, label: '2 Jam', sublabel: 'Sesi extended' },
    ];

    return (
        <div className="space-y-2">
            {options.map((option) => (
                <button
                    key={option.hours}
                    onClick={() => onChange(option.hours)}
                    disabled={locked}
                    className={`w-full rounded-lg border-2 p-3 text-left transition-colors ${
                        duration === option.hours
                            ? 'border-primary bg-primary/5'
                            : 'border-border hover:border-primary/50'
                    } ${locked ? 'cursor-not-allowed opacity-60' : ''}`}
                >
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="font-medium">{option.label}</p>
                            <p className="text-sm text-muted-foreground">
                                {option.sublabel}
                            </p>
                        </div>
                        <Clock className="h-5 w-5 text-muted-foreground" />
                    </div>
                </button>
            ))}
        </div>
    );
};
