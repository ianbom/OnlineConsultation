import { useEffect, useState } from 'react';

/**
 * Custom hook for countdown timer functionality
 * @param expiryTime - The expiry date to countdown to
 * @returns Formatted time left string or null if no expiry time
 */
export const useCountdown = (expiryTime: Date | null): string | null => {
    const [timeLeft, setTimeLeft] = useState<string | null>(null);

    useEffect(() => {
        if (!expiryTime) return;

        const interval = setInterval(() => {
            const now = new Date().getTime();
            const diff = expiryTime.getTime() - now;

            if (diff <= 0) {
                setTimeLeft('Kadaluarsa');
                clearInterval(interval);
                return;
            }

            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            setTimeLeft(`${hours}j ${minutes}m ${seconds}d`);
        }, 1000);

        return () => clearInterval(interval);
    }, [expiryTime]);

    return timeLeft;
};
