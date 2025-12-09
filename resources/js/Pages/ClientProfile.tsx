import { useState, useEffect } from "react";
import { PageLayout } from "@/components/layout/PageLayout";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Switch } from "@/components/ui/switch";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Separator } from "@/components/ui/separator";
import { SkeletonCard } from "@/components/ui/skeleton-card";
import { Camera, Mail, Phone, Lock, Bell, User, Calendar } from "lucide-react";
import { useToast } from "@/hooks/use-toast";
import { format } from "date-fns";
import clientProfileData from "@/data/clientProfile.json";

export default function ClientProfile() {
  const { toast } = useToast();
  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);
  const [profile, setProfile] = useState(clientProfileData);
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    phone: "",
    password: "",
    confirmPassword: "",
  });

  useEffect(() => {
    const timer = setTimeout(() => {
      setFormData({
        name: profile.name,
        email: profile.email,
        phone: profile.phone,
        password: "",
        confirmPassword: "",
      });
      setLoading(false);
    }, 600);
    return () => clearTimeout(timer);
  }, [profile]);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setFormData((prev) => ({
      ...prev,
      [e.target.name]: e.target.value,
    }));
  };

  const handleSave = () => {
    setSaving(true);
    setTimeout(() => {
      setSaving(false);
      toast({
        title: "Profile updated",
        description: "Your profile has been successfully updated.",
      });
    }, 1000);
  };

  if (loading) {
    return (
      <PageLayout title="My Profile">
        <div className="max-w-4xl mx-auto">
          <div className="grid gap-6 md:grid-cols-3">
            <SkeletonCard />
            <div className="md:col-span-2 space-y-6">
              <SkeletonCard />
              <SkeletonCard />
            </div>
          </div>
        </div>
      </PageLayout>
    );
  }

  return (
    <PageLayout title="My Profile" description="Manage your account settings and preferences">
      <div className="max-w-4xl mx-auto">
        <div className="grid gap-6 md:grid-cols-3">
          {/* Profile Preview */}
          <div className="space-y-6">
            <Card>
              <CardContent className="p-6 text-center">
                <div className="relative inline-block">
                  <Avatar className="h-24 w-24 mx-auto border-4 border-primary/10">
                    <AvatarImage src={profile.photo} alt={profile.name} />
                    <AvatarFallback className="text-2xl">
                      {profile.name.split(" ").map((n) => n[0]).join("")}
                    </AvatarFallback>
                  </Avatar>
                  <button className="absolute bottom-0 right-0 h-8 w-8 rounded-full bg-primary text-primary-foreground flex items-center justify-center shadow-md hover:bg-primary/90 transition-colors">
                    <Camera className="h-4 w-4" />
                  </button>
                </div>
                <h2 className="font-display text-xl font-semibold text-foreground mt-4">
                  {profile.name}
                </h2>
                <p className="text-sm text-muted-foreground">{profile.email}</p>
                <div className="flex items-center justify-center gap-1 mt-2 text-sm text-muted-foreground">
                  <Calendar className="h-4 w-4" />
                  <span>Member since {format(new Date(profile.memberSince), "MMMM yyyy")}</span>
                </div>
              </CardContent>
            </Card>

            {/* Quick Stats */}
            <Card>
              <CardHeader className="pb-3">
                <CardTitle className="text-base">Quick Stats</CardTitle>
              </CardHeader>
              <CardContent className="space-y-3">
                <div className="flex justify-between text-sm">
                  <span className="text-muted-foreground">Total Sessions</span>
                  <span className="font-medium text-foreground">12</span>
                </div>
                <div className="flex justify-between text-sm">
                  <span className="text-muted-foreground">Hours of Therapy</span>
                  <span className="font-medium text-foreground">12h</span>
                </div>
                <div className="flex justify-between text-sm">
                  <span className="text-muted-foreground">Active Since</span>
                  <span className="font-medium text-foreground">11 months</span>
                </div>
              </CardContent>
            </Card>
          </div>

          {/* Settings Forms */}
          <div className="md:col-span-2 space-y-6">
            {/* Personal Information */}
            <Card>
              <CardHeader>
                <CardTitle className="text-lg flex items-center gap-2">
                  <User className="h-5 w-5 text-primary" />
                  Personal Information
                </CardTitle>
              </CardHeader>
              <CardContent className="space-y-4">
                <div className="grid gap-4 sm:grid-cols-2">
                  <div className="space-y-2">
                    <Label htmlFor="name">Full Name</Label>
                    <Input
                      id="name"
                      name="name"
                      value={formData.name}
                      onChange={handleChange}
                      placeholder="Enter your name"
                    />
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="phone">Phone Number</Label>
                    <div className="relative">
                      <Phone className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                      <Input
                        id="phone"
                        name="phone"
                        value={formData.phone}
                        onChange={handleChange}
                        placeholder="Enter phone number"
                        className="pl-10"
                      />
                    </div>
                  </div>
                </div>
                <div className="space-y-2">
                  <Label htmlFor="email">Email Address</Label>
                  <div className="relative">
                    <Mail className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                    <Input
                      id="email"
                      name="email"
                      type="email"
                      value={formData.email}
                      onChange={handleChange}
                      placeholder="Enter email address"
                      className="pl-10"
                    />
                  </div>
                </div>
              </CardContent>
            </Card>

            {/* Password */}
            <Card>
              <CardHeader>
                <CardTitle className="text-lg flex items-center gap-2">
                  <Lock className="h-5 w-5 text-primary" />
                  Change Password
                </CardTitle>
              </CardHeader>
              <CardContent className="space-y-4">
                <div className="grid gap-4 sm:grid-cols-2">
                  <div className="space-y-2">
                    <Label htmlFor="password">New Password</Label>
                    <Input
                      id="password"
                      name="password"
                      type="password"
                      value={formData.password}
                      onChange={handleChange}
                      placeholder="Enter new password"
                    />
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="confirmPassword">Confirm Password</Label>
                    <Input
                      id="confirmPassword"
                      name="confirmPassword"
                      type="password"
                      value={formData.confirmPassword}
                      onChange={handleChange}
                      placeholder="Confirm new password"
                    />
                  </div>
                </div>
              </CardContent>
            </Card>

            {/* Notifications */}
            <Card>
              <CardHeader>
                <CardTitle className="text-lg flex items-center gap-2">
                  <Bell className="h-5 w-5 text-primary" />
                  Notification Preferences
                </CardTitle>
              </CardHeader>
              <CardContent className="space-y-4">
                <div className="flex items-center justify-between">
                  <div>
                    <p className="font-medium text-foreground">Push Notifications</p>
                    <p className="text-sm text-muted-foreground">
                      Receive notifications about appointments and updates
                    </p>
                  </div>
                  <Switch defaultChecked={profile.preferences.notifications} />
                </div>
                <Separator />
                <div className="flex items-center justify-between">
                  <div>
                    <p className="font-medium text-foreground">Email Reminders</p>
                    <p className="text-sm text-muted-foreground">
                      Get email reminders before your sessions
                    </p>
                  </div>
                  <Switch defaultChecked={profile.preferences.emailReminders} />
                </div>
                <Separator />
                <div className="flex items-center justify-between">
                  <div>
                    <p className="font-medium text-foreground">SMS Reminders</p>
                    <p className="text-sm text-muted-foreground">
                      Receive text message reminders
                    </p>
                  </div>
                  <Switch defaultChecked={profile.preferences.smsReminders} />
                </div>
              </CardContent>
            </Card>

            {/* Save Button */}
            <div className="flex justify-end">
              <Button size="lg" onClick={handleSave} disabled={saving}>
                {saving ? "Saving..." : "Save Changes"}
              </Button>
            </div>
          </div>
        </div>
      </div>
    </PageLayout>
  );
}
