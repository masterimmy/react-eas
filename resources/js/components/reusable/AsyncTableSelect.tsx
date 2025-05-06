import { useState, useEffect } from 'react';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Label } from "@/components/ui/label";
import { Command, CommandEmpty, CommandGroup, CommandInput, CommandItem } from "@/components/ui/command"
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover"
import { Check, ChevronsLeftRight } from "lucide-react";
import { cn } from "@/lib/utils"
import axios from 'axios';
import { Button } from "@/components/ui/button";

interface Option {
    value: string | number;
    label: string;
}

interface AsyncTableSelectProps {
    tableName: string;
    valueColumn?: string;
    labelColumn?: string;
    label?: string;
    value?: string | number;
    onChange: (value: string | number) => void;
    required?: boolean;
    placeholder?: string;
}

export default function AsyncTableSelect({ 
    tableName, 
    valueColumn = 'id',
    labelColumn = 'name',
    label, 
    value, 
    onChange, 
    required = false,
    placeholder = "Select an option..."
}: AsyncTableSelectProps) {
    const [open, setOpen] = useState(false);
    const [options, setOptions] = useState<Option[]>([]);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        const fetchData = async () => {
            try {
                setLoading(true);
                setError(null);
                const response = await axios.get(
                    `/table-data/${tableName}?value=${valueColumn}&label=${labelColumn}`
                );
                setOptions(response.data);
            } catch (err) {
                setError('Failed to fetch data');
                console.error('Error fetching data:', err);
            } finally {
                setLoading(false);
            }
        };

        if (tableName) {
            fetchData();
        }
    }, [tableName, valueColumn, labelColumn]);

    return (
        <div className="flex flex-col gap-2">
            {label && (
                <Label>
                    {label}
                    {required && <span className="text-red-500"> *</span>}
                </Label>
            )}
            <Popover open={open} onOpenChange={setOpen}>
                <PopoverTrigger asChild>
                    <Button
                        variant="outline"
                        role="combobox"
                        aria-expanded={open}
                        className="w-full justify-between"
                        disabled={loading}
                    >
                        {value ? options.find((option) => option.value.toString() === value.toString())?.label : placeholder}
                        <ChevronsLeftRight className="ml-2 h-4 w-4 shrink-0 opacity-50" />
                    </Button>
                </PopoverTrigger>
                <PopoverContent className="w-full p-0">
                    <Command>
                        <CommandInput placeholder={`Search ${label?.toLowerCase() || 'option'}...`} />
                        <CommandEmpty>{error ? error : 'No options found.'}</CommandEmpty>
                        <CommandGroup className="max-h-60 overflow-auto">
                            {options.map((option) => (
                                <CommandItem
                                    key={option.value}
                                    value={option.label}
                                    onSelect={() => {
                                        onChange(option.value);
                                        setOpen(false);
                                    }}
                                >
                                    <Check
                                        className={cn(
                                            "mr-2 h-4 w-4",
                                            value?.toString() === option.value.toString() ? "opacity-100" : "opacity-0"
                                        )}
                                    />
                                    {option.label}
                                </CommandItem>
                            ))}
                        </CommandGroup>
                    </Command>
                </PopoverContent>
            </Popover>
        </div>
    );
}