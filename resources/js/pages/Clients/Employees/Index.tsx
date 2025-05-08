import AppLayout from '@/layouts/tenant-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Button } from "@/components/ui/button";
import { format } from 'date-fns';
import { toast } from "sonner"
import { getTenantUrl } from '@/lib/utils';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Employees',
        href: '/employees',
    },
];

export default function Dashboard({ tenants }: { tenants: { data: { id: number; tenant_name: string; tenancy_db_email: string; status: string; type: string; reseller: string; valid_from: string; valid_till: string; }[] } }) {

    const actionButton = (
        <Button asChild variant="outline" className="ml-auto">
            <Link href="/employees/create">Add Employee</Link>
        </Button>
    );

    return (
        <AppLayout
            breadcrumbs={breadcrumbs}
            actionButton={actionButton}
        >
            <Head title="Employees" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                   
                </div>
            </div>
        </AppLayout>
    );
}
