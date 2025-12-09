import { useState, useEffect } from "react";
import { useParams, Link } from "react-router-dom";
import { PageLayout } from "@/components/layout/PageLayout";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { SkeletonCard } from "@/components/ui/skeleton-card";
import {
  Star,
  GraduationCap,
  Briefcase,
  Calendar,
  Clock,
  ChevronLeft,
} from "lucide-react";
import counselorsData from "@/data/counselors.json";

const dayNames = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

export default function CounselorProfile() {
  const { id } = useParams();
  const [loading, setLoading] = useState(true);
  const [counselor, setCounselor] = useState<(typeof counselorsData)[0] | null>(null);

  useEffect(() => {
    const timer = setTimeout(() => {
      const found = counselorsData.find((c) => c.id === id);
      setCounselor(found || null);
      setLoading(false);
    }, 600);
    return () => clearTimeout(timer);
  }, [id]);

  if (loading) {
    return (
      <PageLayout>
        <div className="max-w-4xl mx-auto">
          <SkeletonCard className="mb-6" />
          <div className="grid gap-6 md:grid-cols-3">
            <div className="md:col-span-2 space-y-6">
              <SkeletonCard />
              <SkeletonCard />
            </div>
            <SkeletonCard />
          </div>
        </div>
      </PageLayout>
    );
  }

  if (!counselor) {
    return (
      <PageLayout>
        <div className="text-center py-12">
          <h2 className="text-xl font-semibold text-foreground">Counselor not found</h2>
          <Button asChild className="mt-4">
            <Link to="/counselors">Back to Counselors</Link>
          </Button>
        </div>
      </PageLayout>
    );
  }

  return (
    <PageLayout>
      <div className="max-w-4xl mx-auto">
        {/* Back Button */}
        <Button variant="ghost" asChild className="mb-4">
          <Link to="/counselors">
            <ChevronLeft className="h-4 w-4 mr-1" />
            Back to Counselors
          </Link>
        </Button>

        {/* Profile Header */}
        <Card className="mb-6 overflow-hidden">
          <div className="h-24 gradient-primary" />
          <CardContent className="relative pt-0 pb-6">
            <div className="flex flex-col sm:flex-row gap-4 sm:items-end -mt-12">
              <Avatar className="h-24 w-24 border-4 border-card rounded-xl">
                <AvatarImage src={counselor.photo} alt={counselor.name} className="object-cover" />
                <AvatarFallback className="text-2xl rounded-xl">
                  {counselor.name.split(" ").map((n) => n[0]).join("")}
                </AvatarFallback>
              </Avatar>
              <div className="flex-1">
                <div className="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                  <h1 className="font-display text-2xl font-semibold text-foreground">
                    {counselor.name}
                  </h1>
                  <Badge variant={counselor.isAvailable ? "success" : "secondary"}>
                    {counselor.isAvailable ? "Available" : "Unavailable"}
                  </Badge>
                </div>
                <div className="flex items-center gap-1 mt-1">
                  <Star className="h-5 w-5 fill-warning text-warning" />
                  <span className="font-medium text-foreground">{counselor.rating}</span>
                  <span className="text-muted-foreground">({counselor.reviewCount} reviews)</span>
                </div>
              </div>
              <div className="text-right">
                <span className="text-2xl font-semibold text-foreground">
                  ${counselor.pricePerSession}
                </span>
                <span className="text-muted-foreground">/session</span>
              </div>
            </div>
          </CardContent>
        </Card>

        <div className="grid gap-6 md:grid-cols-3">
          {/* Main Content */}
          <div className="md:col-span-2 space-y-6">
            {/* About */}
            <Card>
              <CardHeader>
                <CardTitle className="text-lg">About</CardTitle>
              </CardHeader>
              <CardContent>
                <p className="text-muted-foreground leading-relaxed">{counselor.bio}</p>
                <div className="flex flex-wrap gap-2 mt-4">
                  {counselor.specializations.map((spec) => (
                    <Badge key={spec} variant="secondary">
                      {spec}
                    </Badge>
                  ))}
                </div>
              </CardContent>
            </Card>

            {/* Education */}
            <Card>
              <CardHeader>
                <CardTitle className="text-lg flex items-center gap-2">
                  <GraduationCap className="h-5 w-5 text-primary" />
                  Education
                </CardTitle>
              </CardHeader>
              <CardContent>
                <ul className="space-y-2">
                  {counselor.education.map((edu, index) => (
                    <li key={index} className="text-muted-foreground flex items-start gap-2">
                      <span className="h-1.5 w-1.5 rounded-full bg-primary mt-2 shrink-0" />
                      {edu}
                    </li>
                  ))}
                </ul>
              </CardContent>
            </Card>

            {/* Experience */}
            <Card>
              <CardHeader>
                <CardTitle className="text-lg flex items-center gap-2">
                  <Briefcase className="h-5 w-5 text-primary" />
                  Experience
                </CardTitle>
              </CardHeader>
              <CardContent>
                <ul className="space-y-2">
                  {counselor.experience.map((exp, index) => (
                    <li key={index} className="text-muted-foreground flex items-start gap-2">
                      <span className="h-1.5 w-1.5 rounded-full bg-primary mt-2 shrink-0" />
                      {exp}
                    </li>
                  ))}
                </ul>
              </CardContent>
            </Card>
          </div>

          {/* Sidebar */}
          <div className="space-y-6">
            {/* Schedule Overview */}
            <Card>
              <CardHeader>
                <CardTitle className="text-lg flex items-center gap-2">
                  <Calendar className="h-5 w-5 text-primary" />
                  Availability
                </CardTitle>
              </CardHeader>
              <CardContent>
                <div className="space-y-3">
                  {dayNames.map((day) => {
                    const dayKey = day.toLowerCase() as keyof typeof counselor.availability;
                    const slots = counselor.availability[dayKey];
                    return (
                      <div key={day} className="flex items-center justify-between text-sm">
                        <span className="text-foreground font-medium">{day}</span>
                        <span className="text-muted-foreground">
                          {slots.length > 0 ? `${slots.length} slots` : "Unavailable"}
                        </span>
                      </div>
                    );
                  })}
                </div>
              </CardContent>
            </Card>

            {/* Booking CTA */}
            <Card className="border-primary/20 bg-primary/5">
              <CardContent className="p-5 space-y-4">
                <div className="flex items-center gap-2 text-foreground">
                  <Clock className="h-5 w-5 text-primary" />
                  <span className="font-medium">60 min session</span>
                </div>
                <div className="text-2xl font-semibold text-foreground">
                  ${counselor.pricePerSession}
                </div>
                <div className="space-y-2">
                  <Button className="w-full" size="lg" asChild>
                    <Link to={`/schedule/${counselor.id}`}>Pick Schedule</Link>
                  </Button>
                  <Button variant="outline" className="w-full" asChild>
                    <Link to={`/book/${counselor.id}`}>Book Now</Link>
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
