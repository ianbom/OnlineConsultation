import { useState, useMemo } from "react";
import { PageLayout } from "@/Components/layout/PageLayout";
import { CounselorCard } from "@/Components/counselors/CounselorCard";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import { Badge } from "@/Components/ui/badge";
import { EmptyState } from "@/Components/ui/empty-state";
import { Search, SlidersHorizontal, X } from "lucide-react";
import { usePage } from "@inertiajs/react";

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
  { label: "Under 50k", min: 0, max: 50000 },
  { label: "50k - 100k", min: 50000, max: 100000 },
  { label: "Over 100k", min: 100001, max: Infinity },
];

export default function CounselorsList() {
  const { props } = usePage();
  const counselors = props.counselors as any[];

  console.log("Counselors:", counselors[0].user.profile_pic);

  const [searchQuery, setSearchQuery] = useState("");
  const [selectedSpec, setSelectedSpec] = useState("All");
  const [selectedPriceRange, setSelectedPriceRange] = useState(0);
  const [showFilters, setShowFilters] = useState(false);

  // Filter logic
  const filteredCounselors = useMemo(() => {
    return counselors.filter((c) => {
      const name = c.user?.name ?? "";
      const spec = c.specialization ?? "";
      const price = c.price_per_session ?? 0;

      if (searchQuery && !name.toLowerCase().includes(searchQuery.toLowerCase()))
        return false;

      if (selectedSpec !== "All" && !spec.includes(selectedSpec)) return false;

      const range = priceRanges[selectedPriceRange];
      if (price < range.min || price > range.max) return false;

      return true;
    });
  }, [counselors, searchQuery, selectedSpec, selectedPriceRange]);

  const activeFiltersCount =
    (selectedSpec !== "All" ? 1 : 0) +
    (selectedPriceRange !== 0 ? 1 : 0);

  const clearFilters = () => {
    setSelectedSpec("All");
    setSelectedPriceRange(0);
  };

  return (
    <PageLayout
      title="Temukan Konselor Pilihan Anda"
      description="Berkonsultasilah dengan konselor profesional kami untuk mendukung kesehatan mental Anda."
    >
      {/* Search & Filters */}
      <div className="mb-6 space-y-4">
        <div className="flex gap-3">
          <div className="relative flex-1">
            <Search className="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
            <Input
              placeholder="Cari nama konselor..."
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              className="pl-10"
            />
          </div>

          <Button
            variant={showFilters ? "secondary" : "outline"}
            onClick={() => setShowFilters(!showFilters)}
          >
            <SlidersHorizontal className="h-4 w-4 mr-2" />
            Filter
            {activeFiltersCount > 0 && (
              <Badge className="ml-2">{activeFiltersCount}</Badge>
            )}
          </Button>
        </div>

        {/* Expand Filters */}
        {showFilters && (
          <div className="p-4 rounded-xl border bg-card space-y-4 animate-fade-in">
            <div className="flex justify-between items-center">
              <h3 className="font-medium">Filters</h3>
              {activeFiltersCount > 0 && (
                <Button variant="ghost" size="sm" onClick={clearFilters}>
                  Clear all <X className="ml-1 h-4 w-4" />
                </Button>
              )}
            </div>

            {/* Specialization */}
            <div>
              <label className="text-sm text-muted-foreground mb-2 block">
                Spesialisasi
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
                Rentang Harga
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
          </div>
        )}
      </div>

      {/* Results */}
      {filteredCounselors.length > 0 ? (
        <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
          {filteredCounselors.map((c) => (
            <CounselorCard
              key={c.id}
              id={c.id}
              name={c.user?.name ?? "Unknown"}
              photo={c.user?.profile_pic ?? ""}
              specializations={c.specialization ? c.specialization.split(" ") : []}
              rating={4.8}
              reviewCount={20}
              pricePerSession={c.price_per_session}
              isAvailable={true}
            />
          ))}
        </div>
      ) : (
        <EmptyState
          icon="search"
          title="No counselors found"
          description="Try adjusting your search or filters."
        />
      )}
    </PageLayout>
  );
}
