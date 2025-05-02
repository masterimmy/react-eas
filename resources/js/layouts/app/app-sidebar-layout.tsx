import { AppContent } from '@/components/app-content';
import { AppShell } from '@/components/app-shell';
import { AppSidebar } from '@/components/app-sidebar';
import { AppSidebarHeader } from '@/components/app-sidebar-header';
import { type BreadcrumbItem } from '@/types';
import { type PropsWithChildren, type ReactNode } from 'react';

interface AppSidebarLayoutProps {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
    actionButton?: ReactNode | undefined;
}

export default function AppSidebarLayout({ 
    children, 
    breadcrumbs = [],
    actionButton
}: AppSidebarLayoutProps) {
    return (
        <AppShell variant="sidebar">
            <AppSidebar />
            <AppContent variant="sidebar">
                <AppSidebarHeader 
                    breadcrumbs={breadcrumbs} 
                    actionButton={actionButton}
                />
                {children}
            </AppContent>
        </AppShell>
    );
}