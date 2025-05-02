import { Breadcrumbs } from '@/components/breadcrumbs';
import { SidebarTrigger } from '@/components/ui/sidebar';
import { type BreadcrumbItem as BreadcrumbItemType } from '@/types';
import { type ReactNode } from 'react';

interface AppSidebarHeaderProps {
    breadcrumbs?: BreadcrumbItemType[];
    actionButton?: ReactNode | undefined;
}

export function AppSidebarHeader({ breadcrumbs = [], actionButton = undefined }: AppSidebarHeaderProps) {
    return (
        <header className="border-sidebar-border/50 flex h-16 shrink-0 items-center gap-2 border-b px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4">
            <div className="flex items-center gap-2 w-full justify-between">
                <div className="flex items-center gap-2">
                    <SidebarTrigger className="-ml-1" />
                    <Breadcrumbs breadcrumbs={breadcrumbs} />
                </div>
                {actionButton && (
                    <div className="flex items-center">
                        {actionButton}
                    </div>
                )}
            </div>
        </header>
    );
}