import { useState } from 'react';
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input"
import InputError from "@/components/input-error";
import { Label } from "@/components/ui/label"
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, Link, router } from '@inertiajs/react';
import { format } from "date-fns";
import { CalendarIcon } from "lucide-react";
import { cn } from "@/lib/utils"
import { Calendar } from "@/components/ui/calendar"
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover"
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from "@/components/ui/select";
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from "@/components/ui/alert-dialog"
import { toast } from "sonner"


export default function Create({ tenant }: { tenant: any }) {

    const [open, setOpen] = useState(false);

    const handleDelete = () => {
        router.delete(`/tenants/${tenant.id}`, {
            preserveScroll: true,
            onSuccess: () => toast.success("Tenant has been deleted."),
            onError: () => toast.error("Something went wrong."),
        });
    };

    const actionButton = tenant?.id ? (
        <>
            <AlertDialog open={open} onOpenChange={setOpen}>
                <AlertDialogTrigger asChild>
                    <Button variant="destructive" className="ml-auto">
                        Delete
                    </Button>
                </AlertDialogTrigger>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                        <AlertDialogDescription>
                            This action cannot be undone. This will permanently delete the tenant
                            and remove all associated data from our servers.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction 
                            onClick={handleDelete}
                            className="bg-destructive hover:bg-destructive/90"
                        >
                            Delete
                        </AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </>
    ) : null;

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Tenants',
            href: '/tenants',
        },
        {
            title: tenant?.id ? 'Edit' : 'Create',
            href: tenant?.id ? `/tenants/${tenant.id}/edit` : '/tenants/create',
        },
    ];

    const { data, setData, post, put, processing, errors } = useForm({
        organization_name: tenant?.tenant_name || '',
        organization_domain: tenant?.tenancy_db_name || '',
        organization_user_name: tenant?.tenant_contact_name || '',
        organization_user_mobile: tenant?.tenant_contact_number || '',
        organization_user_email: tenant?.tenancy_db_email || '',
        organization_valid_from: tenant?.valid_from ? new Date(tenant.valid_from) : null,
        organization_valid_till: tenant?.valid_till ? new Date(tenant.valid_till) : null,
        organization_license_user_count: tenant?.license_user_count || '',
        organization_timezone: tenant?.base_timezone || '',
        organization_logo: tenant?.organization_logo || '',
        logo_preview: tenant?.tenant_logo || null,
    });

    function submit(e: React.FormEvent) {
        e.preventDefault();
        if (tenant?.id) {
            put(`/tenants/${tenant.id}`, {
                preserveScroll: true,
                onSuccess: () => toast.success("Event has been created."),
                onError: () => toast.error("Something went wrong."),
            });
        } else {
            post('/tenants', {
                preserveScroll: true,
            });
        }
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs} actionButton={actionButton}>
            <Head title={`${tenant?.id ? 'Edit' : 'Create'} Tenant`} />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <form onSubmit={submit} className="space-y-8">
                    <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                        <div>
                            <Label htmlFor="tenant_name"> Organization Name <span className="text-red-500">*</span></Label>
                            <Input type="text" id="tenant_name" value={data.organization_name} onChange={e => setData('organization_name', e.target.value)} required />
                            <InputError message={errors.organization_name} className="mt-2" />
                        </div>
                        <div>
                            <Label htmlFor="organization_domain"> Domain Name <span className="text-red-500">*</span></Label>
                            <Input type="text" id="organization_domain" value={data.organization_domain} onChange={e => setData('organization_domain', e.target.value)} required />
                            <InputError message={errors.organization_domain} className="mt-2" />
                        </div>
                        <div>
                            <Label htmlFor="organization_user_name">User Name <span className="text-red-500">*</span></Label>
                            <Input type="text" id="organization_user_name" value={data.organization_user_name} onChange={e => setData('organization_user_name', e.target.value)} required />
                            <InputError message={errors.organization_user_name} className="mt-2" />
                        </div>
                        <div>
                            <Label htmlFor="organization_user_mobile"> User Contact <span className="text-red-500">*</span></Label>
                            <Input type="number" id="organization_user_mobile" value={data.organization_user_mobile} onChange={e => setData('organization_user_mobile', e.target.value)} required />
                            <InputError message={errors.organization_user_mobile} className="mt-2" />
                        </div>
                        <div>
                            <Label htmlFor="organization_user_email"> User Email ID <span className="text-red-500">*</span></Label>
                            <Input type="email" id="organization_user_email" value={data.organization_user_email} onChange={e => setData('organization_user_email', e.target.value)} required />
                            <InputError message={errors.organization_user_email} className="mt-2" />
                        </div>
                        <div>
                            <Label htmlFor="organization_valid_from">Subscription Valid From <span className="text-red-500">*</span></Label>
                            {/* <Input type="date" id="organization_valid_from" value={data.organization_valid_from} onChange={e => setData('organization_valid_from', e.target.value)} required /> */}
                            <Popover>
                                <PopoverTrigger asChild>
                                    <Button
                                        variant={"outline"}
                                        className={cn(
                                            "w-full justify-start text-left font-normal",
                                            !data.organization_valid_from && "text-muted-foreground"
                                        )}
                                    >
                                        <CalendarIcon />
                                        {data.organization_valid_from ? format(data.organization_valid_from, "PPP") : <span>Pick a date</span>}
                                    </Button>
                                </PopoverTrigger>
                                <PopoverContent className="w-auto p-0" align="start">
                                    <Calendar
                                        mode="single"
                                        selected={data.organization_valid_from ? new Date(data.organization_valid_from) : undefined}
                                        onSelect={(date: Date | undefined) => setData('organization_valid_from', date || null)}
                                        initialFocus
                                    />
                                </PopoverContent>
                            </Popover>
                            <InputError message={errors.organization_valid_from} className="mt-2" />
                        </div>
                        <div>
                            <Label htmlFor="organization_valid_till">Subscription Valid Till <span className="text-red-500">*</span></Label>
                            {/* <Input type="date" id="organization_valid_till" value={data.organization_valid_till} onChange={e => setData('organization_valid_till', e.target.value)} required /> */}
                            <Popover>
                                <PopoverTrigger asChild>
                                    <Button
                                        variant={"outline"}
                                        className={cn(
                                            "w-full justify-start text-left font-normal",
                                            !data.organization_valid_till && "text-muted-foreground"
                                        )}
                                    >
                                        <CalendarIcon />
                                        {data.organization_valid_till ? format(data.organization_valid_till, "PPP") : <span>Pick a date</span>}
                                    </Button>
                                </PopoverTrigger>
                                <PopoverContent className="w-auto p-0" align="start">
                                    <Calendar
                                        mode="single"
                                        selected={data.organization_valid_till ? new Date(data.organization_valid_till) : undefined}
                                        onSelect={(date: Date | undefined) => setData('organization_valid_till', date || null)}
                                        initialFocus
                                    />
                                </PopoverContent>
                            </Popover>
                            <InputError message={errors.organization_valid_till} className="mt-2" />
                        </div>
                        <div>
                            <Label htmlFor="organization_license_user_count">Licensed User Count <span className="text-red-500">*</span></Label>
                            <Input type="number" id="organization_license_user_count" value={data.organization_license_user_count} onChange={e => setData('organization_license_user_count', e.target.value)} required />
                            <InputError message={errors.organization_license_user_count} className="mt-2" />
                        </div>
                        <div>
                            <Label htmlFor="organization_timezone">Base Timezone <span className="text-red-500">*</span></Label>
                            <Select onValueChange={(value) => setData('organization_timezone', value)}>
                                <SelectTrigger className="w-full">
                                    <SelectValue placeholder="Select a timezone" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>North America</SelectLabel>
                                        <SelectItem value="est">Eastern Standard Time (EST)</SelectItem>
                                        <SelectItem value="cst">Central Standard Time (CST)</SelectItem>
                                        <SelectItem value="mst">Mountain Standard Time (MST)</SelectItem>
                                        <SelectItem value="pst">Pacific Standard Time (PST)</SelectItem>
                                        <SelectItem value="akst">Alaska Standard Time (AKST)</SelectItem>
                                        <SelectItem value="hst">Hawaii Standard Time (HST)</SelectItem>
                                    </SelectGroup>
                                    <SelectGroup>
                                        <SelectLabel>Europe & Africa</SelectLabel>
                                        <SelectItem value="gmt">Greenwich Mean Time (GMT)</SelectItem>
                                        <SelectItem value="cet">Central European Time (CET)</SelectItem>
                                        <SelectItem value="eet">Eastern European Time (EET)</SelectItem>
                                        <SelectItem value="west">
                                            Western European Summer Time (WEST)
                                        </SelectItem>
                                        <SelectItem value="cat">Central Africa Time (CAT)</SelectItem>
                                        <SelectItem value="eat">East Africa Time (EAT)</SelectItem>
                                    </SelectGroup>
                                    <SelectGroup>
                                        <SelectLabel>Asia</SelectLabel>
                                        <SelectItem value="msk">Moscow Time (MSK)</SelectItem>
                                        <SelectItem value="ist">India Standard Time (IST)</SelectItem>
                                        <SelectItem value="cst_china">China Standard Time (CST)</SelectItem>
                                        <SelectItem value="jst">Japan Standard Time (JST)</SelectItem>
                                        <SelectItem value="kst">Korea Standard Time (KST)</SelectItem>
                                        <SelectItem value="ist_indonesia">
                                            Indonesia Central Standard Time (WITA)
                                        </SelectItem>
                                    </SelectGroup>
                                    <SelectGroup>
                                        <SelectLabel>Australia & Pacific</SelectLabel>
                                        <SelectItem value="awst">
                                            Australian Western Standard Time (AWST)
                                        </SelectItem>
                                        <SelectItem value="acst">
                                            Australian Central Standard Time (ACST)
                                        </SelectItem>
                                        <SelectItem value="aest">
                                            Australian Eastern Standard Time (AEST)
                                        </SelectItem>
                                        <SelectItem value="nzst">New Zealand Standard Time (NZST)</SelectItem>
                                        <SelectItem value="fjt">Fiji Time (FJT)</SelectItem>
                                    </SelectGroup>
                                    <SelectGroup>
                                        <SelectLabel>South America</SelectLabel>
                                        <SelectItem value="art">Argentina Time (ART)</SelectItem>
                                        <SelectItem value="bot">Bolivia Time (BOT)</SelectItem>
                                        <SelectItem value="brt">Brasilia Time (BRT)</SelectItem>
                                        <SelectItem value="clt">Chile Standard Time (CLT)</SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                            <InputError message={errors.organization_timezone} className="mt-2" />
                        </div>
                        <div className="flex flex-col gap-4">
                            <Label htmlFor="organization_logo">Upload Company Logo </Label>
                            <div className="flex items-start gap-4">
                                <div className="flex-1">
                                    <Input
                                        type="file"
                                        id="organization_logo"
                                        accept="image/*"
                                        onChange={e => {
                                            const file = e.target.files?.[0];
                                            if (file) {
                                                setData('organization_logo', file);
                                                // Create preview URL
                                                const reader = new FileReader();
                                                reader.onload = (e) => {
                                                    setData('logo_preview', e.target?.result as string);
                                                };
                                                reader.readAsDataURL(file);
                                            }
                                        }}
                                    />
                                    <InputError message={errors.organization_logo} className="mt-2" />
                                </div>
                                {data.logo_preview && (
                                    <div className="w-24 h-24 rounded-lg overflow-hidden border">
                                        <img
                                            src={data.logo_preview}
                                            alt="Logo preview"
                                            className="w-full h-full object-cover"
                                        />
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                    <div className="text-end">
                        <Button type="submit" disabled={processing}>
                            {tenant?.id ? 'Update' : 'Create'} Tenant
                        </Button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
