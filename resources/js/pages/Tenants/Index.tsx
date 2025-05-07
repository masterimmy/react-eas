import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Button } from "@/components/ui/button";
import { format } from 'date-fns';
import { toast } from "sonner"
import { getTenantUrl } from '@/lib/utils';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tenants',
        href: '/tenants',
    },
];

export default function Dashboard({ tenants }: { tenants: { data: { id: number; tenant_name: string; tenancy_db_email: string; status: string; type: string; reseller: string; valid_from: string; valid_till: string; }[] } }) {

    const actionButton = (
        <Button asChild variant="outline" className="ml-auto">
            <Link href="/tenants/create">Add Tenant</Link>
        </Button>
    );

    return (
        <AppLayout
            breadcrumbs={breadcrumbs}
            actionButton={actionButton}
        >
            <Head title="Tenants" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">
                    <Table>
                        {/* <TableCaption>A list of your recent invoices.</TableCaption> */}
                        <TableHeader>
                            <TableRow>
                                <TableHead>Tenant Name</TableHead>
                                <TableHead>Domain</TableHead>
                                <TableHead>Email</TableHead>
                                {/* <TableHead>Status</TableHead>
                                <TableHead>Type</TableHead>
                                <TableHead>Reseller</TableHead> */}
                                <TableHead>Valid From</TableHead>
                                <TableHead>Valid Till</TableHead>
                                <TableHead>Action</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {tenants.data.map((tenant) => (
                                <TableRow key={tenant.id}>
                                    <TableCell className="font-medium">{tenant.tenant_name}</TableCell>
                                    <TableCell>
                                        <a href={getTenantUrl(tenant.id)} target="_blank" className="text-blue-600 hover:underline">
                                            {tenant.id}
                                        </a>
                                    </TableCell>
                                    <TableCell>{tenant.tenancy_db_email}</TableCell>
                                    {/* <TableCell>{tenant.status}</TableCell>
                                    <TableCell>{tenant.type}</TableCell>
                                    <TableCell>{tenant.reseller}</TableCell> */}
                                    <TableCell>{format(new Date(tenant.valid_from), 'dd/MM/yyyy')}</TableCell>
                                    <TableCell>{format(new Date(tenant.valid_till), 'dd/MM/yyyy')}</TableCell>
                                    <TableCell>
                                        <Button asChild variant="link" className="ml-auto">
                                            <Link href={`/tenants/${tenant.id}/edit`}>Edit</Link>
                                        </Button>
                                    </TableCell>
                                </TableRow>
                            ))}

                        </TableBody>
                    </Table>
                </div>
            </div>
        </AppLayout>
    );
}
