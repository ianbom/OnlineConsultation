import { useState, useEffect, useMemo } from "react";
import { PageLayout } from "@/components/layout/PageLayout";
import { CounselorCard } from "@/components/counselors/CounselorCard";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { SkeletonGrid } from "@/components/ui/skeleton-card";
import { EmptyState } from "@/components/ui/empty-state";
import { Search, SlidersHorizontal, X } from "lucide-react";
import counselorsData from "@/data/counselors.json";

const specializations = [
  "All",
  "Anxiety",
  "Depression",
  "Trauma",
  "Relationship Issues",
  "Work Stress",
  "OCD",
  "Addiction",
];

const priceRanges = [
  { label: "All Prices", min: 0, max: Infinity },
  { label: "Under $150", min: 0, max: 149 },
  { label: "$150 - $170", min: 150, max: 170 },
  { label: "Over $170", min: 171, max: Infinity },
];

export default function CounselorsList() {
  const [loading, setLoading] = useState(true);
  const [counselors, setCounselors] = useState<typeof counselorsData>([]);
  const [searchQuery, setSearchQuery] = useState("");
  const [selectedSpec, setSelectedSpec] = useState("All");
  const [selectedPriceRange, setSelectedPriceRange] = useState(0);
  const [showAvailableOnly, setShowAvailableOnly] = useState(false);
  const [showFilters, setShowFilters] = useState(false);

  useEffect(() => {
    const timer = setTimeout(() => {
      setCounselors(counselorsData);
      setLoading(false);
    }, 800);
    return () => clearTimeout(timer);
  }, []);

  const filteredCounselors = useMemo(() => {
    return counselors.filter((counselor) => {
      // Search filter
      if (
        searchQuery &&
        !counselor.name.toLowerCase().includes(searchQuery.toLowerCase())
      ) {
        return false;
      }

      // Specialization filter
      if (
        selectedSpec !== "All" &&
        !counselor.specializations.includes(selectedSpec)
      ) {
        return false;
      }

      // Price filter
      const range = priceRanges[selectedPriceRange];
      if (
        counselor.pricePerSession < range.min ||
        counselor.pricePerSession > range.max
      ) {
        return false;
      }

      // Availability filter
      if (showAvailableOnly && !counselor.isAvailable) {
        return false;
      }

      return true;
    });
  }, [counselors, searchQuery, selectedSpec, selectedPriceRange, showAvailableOnly]);

  const activeFiltersCount =
    (selectedSpec !== "All" ? 1 : 0) +
    (selectedPriceRange !== 0 ? 1 : 0) +
    (showAvailableOnly ? 1 : 0);

  const clearFilters = () => {
    setSelectedSpec("All");
    setSelectedPriceRange(0);
    setShowAvailableOnly(false);
  };

  return (
    <PageLayout
      title="Find Your Counselor"
      description="Connect with experienced mental health professionals"
    >
      {/* Search and Filters */}
      <div className="mb-6 space-y-4">
        <div className="flex gap-3">
          <div className="relative flex-1">
            <Search className="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
            <Input
              placeholder="Search by name..."
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              className="pl-10"
            />
          </div>
          <Button
            variant={showFilters ? "secondary" : "outline"}
            onClick={() => setShowFilters(!showFilters)}
            className="shrink-0"
          >
            <SlidersHorizontal className="h-4 w-4 mr-2" />
            Filters
            {activeFiltersCount > 0 && (
              <Badge variant="default" className="ml-2">
                {activeFiltersCount}
              </Badge>
            )}
          </Button>
        </div>

        {/* Expandable Filters */}
        {showFilters && (
          <div className="p-4 rounded-xl border bg-card space-y-4 animate-fade-in">
            <div className="flex items-center justify-between">
              <h3 className="font-medium text-foreground">Filters</h3>
              {activeFiltersCount > 0 && (
                <Button variant="ghost" size="sm" onClick={clearFilters}>
                  Clear all
                  <X className="h-4 w-4 ml-1" />
                </Button>
              )}
            </div>

            {/* Specialization */}
            <div>
              <label className="text-sm text-muted-foreground mb-2 block">
                Specialization
              </label>
              <div className="flex flex-wrap gap-2">
                {specializations.map((spec) => (
                  <Badge
                    key={spec}
                    variant={selectedSpec === spec ? "default" : "outline"}
                    className="cursor-pointer"
                    onClick={() => setSelectedSpec(spec)}
                  >
                    {spec}
                  </Badge>
                ))}
              </div>
            </div>

            {/* Price Range */}
            <div>
              <label className="text-sm text-muted-foreground mb-2 block">
                Price per Session
              </label>
              <div className="flex flex-wrap gap-2">
                {priceRanges.map((range, index) => (
                  <Badge
                    key={range.label}
                    variant={selectedPriceRange === index ? "default" : "outline"}
                    className="cursor-pointer"
                    onClick={() => setSelectedPriceRange(index)}
                  >
                    {range.label}
                  </Badge>
                ))}
              </div>
            </div>

            {/* Availability */}
            <div className="flex items-center gap-2">
              <input
                type="checkbox"
                id="available"
                checked={showAvailableOnly}
                onChange={(e) => setShowAvailableOnly(e.target.checked)}
                className="h-4 w-4 rounded border-input"
              />
              <label htmlFor="available" className="text-sm text-foreground cursor-pointer">
                Show available only
              </label>
            </div>
          </div>
        )}
      </div>

      {/* Results */}
      {loading ? (
        <SkeletonGrid count={6} />
      ) : filteredCounselors.length > 0 ? (
        <>
          <p className="text-sm text-muted-foreground mb-4">
            {filteredCounselors.length} counselor{filteredCounselors.length !== 1 ? "s" : ""} found
          </p>
          <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            {filteredCounselors.map((counselor) => (
              <CounselorCard
                key={counselor.id}
                id={counselor.id}
                name={counselor.name}
                photo={counselor.photo}
                specializations={counselor.specializations}
                rating={counselor.rating}
                reviewCount={counselor.reviewCount}
                pricePerSession={counselor.pricePerSession}
                isAvailable={counselor.isAvailable}
              />
            ))}
          </div>
        </>
      ) : (
        <EmptyState
          icon="search"
          title="No counselors found"
          description="Try adjusting your search or filters to find what you're looking for."
          action={
            <Button variant="outline" onClick={clearFilters}>
              Clear Filters
            </Button>
          }
        />
      )}
    </PageLayout>
  );
}
