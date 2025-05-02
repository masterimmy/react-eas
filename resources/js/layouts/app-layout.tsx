import AppLayoutTemplate from '@/layouts/app/app-sidebar-layout';
import { type BreadcrumbItem } from '@/types';
import { type ReactNode } from 'react';

interface AppLayoutProps {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
    actionButton?: ReactNode | undefined;
}

export default ({ children, breadcrumbs, actionButton, ...props }: AppLayoutProps) => (
    <AppLayoutTemplate 
        breadcrumbs={breadcrumbs} 
        actionButton={actionButton}
        {...props}
    >
        {children}
    </AppLayoutTemplate>
);