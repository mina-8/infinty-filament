export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export interface SettingSite {
    primary_color?: string;
    secondary_color?: string;
    third_color?: string;
    logo_image?: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
    setting_site?:SettingSite;
};
