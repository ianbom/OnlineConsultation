export default interface User {
  id: number;
  name: string;
  email: string;
  role: 'admin' | 'counselor' | 'client';
  phone: string | null;
  profile_pic: string | null;
  email_verified_at: string | null;
  remember_token?: string | null;
  created_at: string;
  updated_at: string;
}
