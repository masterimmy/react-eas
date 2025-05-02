import { Button } from "@/components/ui/button";
import { Form, FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from "@/components/ui/form";
import { Input } from "@/components/ui/input"
import InputError from "@/components/input-error";
import { Label } from "@/components/ui/label"
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import { format } from "date-fns";
import { CalendarIcon } from "lucide-react";
import { cn } from "@/lib/utils"
import { Calendar } from "@/components/ui/calendar"
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover"
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select"


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tenants',
        href: '/tenants',
    },
    {
        title: 'Create',
        href: '/tenants/create',
    },
];

export default function Dashboard() {

    const { data, setData, post, processing, errors, reset } = useForm({
        organization_name: '',
        organization_domain: '',
        organization_user_name: '',
        organization_user_mobile: '',
        organization_user_email: '',
        organization_valid_from: null as Date | null,
        organization_valid_till: null as Date | null,
        organization_license_user_count: '',
        organization_timezone: '',
        organiation_logo: '',
    })

    function submit(e: any) {
        e.preventDefault()
        post('/tenants', {
            preserveScroll: true,
        })
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Tenants" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <form onSubmit={submit} className="space-y-8">
                    <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                        <div>
                            <Label htmlFor="organization_name">Enter Organization Name <span className="text-red-500">*</span></Label>
                            <Input type="text" id="organization_name" value={data.organization_name} onChange={e => setData('organization_name', e.target.value)} required />
                            <InputError message={errors.organization_name} className="mt-2" />
                        </div>
                        <div>
                            <Label htmlFor="organization_domain">Enter Domain Name <span className="text-red-500">*</span></Label>
                            <Input type="text" id="organization_domain" value={data.organization_domain} onChange={e => setData('organization_domain', e.target.value)} required />
                            <InputError message={errors.organization_domain} className="mt-2" />
                        </div>
                        <div>
                            <Label htmlFor="organization_user_name">User Name <span className="text-red-500">*</span></Label>
                            <Input type="text" id="organization_user_name" value={data.organization_user_name} onChange={e => setData('organization_user_name', e.target.value)} required />
                            <InputError message={errors.organization_user_name} className="mt-2" />
                        </div>
                        <div>
                            <Label htmlFor="organization_user_mobile">Enter User Contact <span className="text-red-500">*</span></Label>
                            <Input type="number" id="organization_user_mobile" value={data.organization_user_mobile} onChange={e => setData('organization_user_mobile', e.target.value)} required />
                            <InputError message={errors.organization_user_mobile} className="mt-2" />
                        </div>
                        <div>
                            <Label htmlFor="organization_user_email">Enter User Email ID <span className="text-red-500">*</span></Label>
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
                            <Label htmlFor="email">Base Timezone <span className="text-red-500">*</span></Label>
                            <Select>
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
                            <InputError message={errors.username} className="mt-2" />
                        </div>
                        <div>
                            <Label htmlFor="email">Upload Comapny Logo <span className="text-red-500">*</span></Label>
                            <Input type="file" id="email" value={data.organization_domain} onChange={e => setData('organization_domain', e.target.value)} required />
                            <InputError message={errors.username} className="mt-2" />
                        </div>
                    </div>
                    <div className="text-end">
                        <Button type="submit" disabled={processing}>Submit</Button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
