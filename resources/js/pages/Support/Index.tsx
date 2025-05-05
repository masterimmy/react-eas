import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Button } from "@/components/ui/button";
import { format } from 'date-fns';
import { toast } from "sonner"


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Support',
        href: '/support',
    },
];

export default function Dashboard({ tickets }: { tickets: { data: { id: string; ticket_display_id: string; }[] } }) {

    return (
        <AppLayout
            breadcrumbs={breadcrumbs}
        >
            <Head title="Tickets" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">
                    <Table>
                        {/* <TableCaption>A list of your recent invoices.</TableCaption> */}
                        <TableHeader>
                            <TableRow>
                                <TableHead>Ticket Number</TableHead>
                                <TableHead>Tenant</TableHead>
                                <TableHead>Title</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead>Request raised at</TableHead>
                                <TableHead>Action</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {tickets.data.map((ticket) => (
                                <TableRow key={ticket.id}>
                                    <TableCell className="font-medium">{ticket.ticket_display_id}</TableCell>
                                    <TableCell>{ticket.tenant_id}</TableCell>
                                    <TableCell>{ticket.title}</TableCell>
                                    <TableCell>{ticket.ticket_status_id}</TableCell>
                                    <TableCell>{format(new Date(ticket.created_at), 'dd/MM/yyyy HH:mm')}</TableCell>
                                    <TableCell>
                                        <Button asChild variant="link" className="ml-auto">
                                            <Link href={`/tenants/${ticket.id}/edit`}>Edit</Link>
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
