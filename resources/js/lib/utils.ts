import { type ClassValue, clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function getTenantUrl(tenantId: string | number): string {
    const appUrl = import.meta.env.VITE_APP_URL || 'http://localhost:8000';
    
    const url = new URL(appUrl);
    
    return `http://${tenantId}.${url.host}`;
}
