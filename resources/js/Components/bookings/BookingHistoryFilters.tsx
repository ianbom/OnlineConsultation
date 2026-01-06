import { Badge } from '@/Components/ui/badge';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/Components/ui/select';
import { BookingSortOption } from '@/utils/booking';
import {
    ArrowUpDown,
    Calendar,
    ChevronDown,
    Filter,
    Search,
    X,
} from 'lucide-react';
import { useState } from 'react';

interface BookingHistoryFiltersProps {
    searchQuery: string;
    onSearchChange: (value: string) => void;
    startDate: string;
    onStartDateChange: (value: string) => void;
    endDate: string;
    onEndDateChange: (value: string) => void;
    sortBy: BookingSortOption;
    onSortChange: (value: BookingSortOption) => void;
    resultCount: number;
    totalCount: number;
    hasActiveFilters: boolean;
    onClear: () => void;
}

export const BookingHistoryFilters: React.FC<BookingHistoryFiltersProps> = ({
    searchQuery,
    onSearchChange,
    startDate,
    onStartDateChange,
    endDate,
    onEndDateChange,
    sortBy,
    onSortChange,
    resultCount,
    totalCount,
    hasActiveFilters,
    onClear,
}) => {
    const [isFilterOpen, setIsFilterOpen] = useState(false);
    const activeFilterCount = [
        searchQuery,
        startDate,
        endDate,
        sortBy !== 'date_desc',
    ].filter(Boolean).length;

    return (
        <>
            {/* ============ FILTER TOGGLE BUTTON (Mobile) ============ */}
            <div className="mb-4 lg:hidden">
                <Button
                    variant="outline"
                    onClick={() => setIsFilterOpen(!isFilterOpen)}
                    className="w-full justify-between"
                >
                    <div className="flex items-center gap-2">
                        <Filter className="h-4 w-4" />
                        <span>Filter & Urutkan</span>
                        {activeFilterCount > 0 && (
                            <Badge
                                variant="default"
                                className="h-5 min-w-[20px] px-1.5"
                            >
                                {activeFilterCount}
                            </Badge>
                        )}
                    </div>
                    <ChevronDown
                        className={`h-4 w-4 transition-transform ${isFilterOpen ? 'rotate-180' : ''}`}
                    />
                </Button>
            </div>

            {/* ============ FILTER SECTION ============ */}
            <div
                className={`mb-4 space-y-4 rounded-lg border bg-white p-4 ${isFilterOpen ? 'block' : 'hidden'} lg:block`}
            >
                {/* Header (Mobile Only) */}
                <div className="flex items-center justify-between border-b pb-2 lg:hidden">
                    <h3 className="text-base font-semibold">
                        Filter & Urutkan
                    </h3>
                    <Button
                        variant="ghost"
                        size="sm"
                        onClick={() => setIsFilterOpen(false)}
                        className="h-8 w-8 p-0"
                    >
                        <X className="h-4 w-4" />
                    </Button>
                </div>

                {/* Filter Grid */}
                <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    {/* Search */}
                    <div className="space-y-2">
                        <label className="text-sm font-medium text-gray-700">
                            Cari Konselor
                        </label>
                        <div className="relative">
                            <Search className="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                            <Input
                                type="text"
                                placeholder="Cari nama..."
                                value={searchQuery}
                                onChange={(e) => onSearchChange(e.target.value)}
                                className="w-full pl-10"
                            />
                        </div>
                    </div>

                    {/* Start Date */}
                    <div className="space-y-2">
                        <label className="text-sm font-medium text-gray-700">
                            Tanggal Mulai
                        </label>
                        <div className="relative">
                            <Calendar className="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                            <Input
                                type="date"
                                value={startDate}
                                onChange={(e) =>
                                    onStartDateChange(e.target.value)
                                }
                                className="w-full pl-10"
                            />
                        </div>
                    </div>

                    {/* End Date */}
                    <div className="space-y-2">
                        <label className="text-sm font-medium text-gray-700">
                            Tanggal Akhir
                        </label>
                        <div className="relative">
                            <Calendar className="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                            <Input
                                type="date"
                                value={endDate}
                                onChange={(e) =>
                                    onEndDateChange(e.target.value)
                                }
                                className="w-full pl-10"
                            />
                        </div>
                    </div>

                    {/* Sort */}
                    <div className="space-y-2">
                        <label className="text-sm font-medium text-gray-700">
                            Urutkan
                        </label>
                        <Select
                            value={sortBy}
                            onValueChange={(v) =>
                                onSortChange(v as BookingSortOption)
                            }
                        >
                            <SelectTrigger className="w-full">
                                <div className="flex items-center gap-2">
                                    <ArrowUpDown className="h-4 w-4" />
                                    <SelectValue />
                                </div>
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="date_desc">
                                    Tanggal (Terbaru)
                                </SelectItem>
                                <SelectItem value="date_asc">
                                    Tanggal (Terlama)
                                </SelectItem>
                                <SelectItem value="name_asc">
                                    Nama (A-Z)
                                </SelectItem>
                                <SelectItem value="name_desc">
                                    Nama (Z-A)
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                </div>

                {/* Action Buttons */}
                <div className="flex flex-col items-stretch justify-between gap-3 border-t pt-2 sm:flex-row sm:items-center">
                    {/* Result Count */}
                    <div className="text-center text-sm text-gray-600 sm:text-left">
                        Menampilkan{' '}
                        <span className="font-semibold">{resultCount}</span>{' '}
                        dari <span className="font-semibold">{totalCount}</span>{' '}
                        booking
                    </div>

                    {/* Clear Filters */}
                    {hasActiveFilters && (
                        <Button
                            variant="outline"
                            size="sm"
                            onClick={onClear}
                            className="w-full sm:w-auto"
                        >
                            <X className="mr-2 h-4 w-4" />
                            Reset Filter
                        </Button>
                    )}
                </div>
            </div>
        </>
    );
};
