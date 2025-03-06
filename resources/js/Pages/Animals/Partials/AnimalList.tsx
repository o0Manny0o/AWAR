import Listing = App.Models.Listing
import { Card } from '@/Components/Layout/Card'
import { Link, usePage } from '@inertiajs/react'

export function AnimalList({ listings }: { listings: Listing[] }) {
    const { tenant } = usePage().props

    return (
        <ul role="list" className="space-y-2 sm:space-y-4">
            {listings.map((listing) => (
                <li key={listing.id} className="">
                    <Link href={route('listings.show', listing.id)}>
                        <Card
                            className=""
                            bodyClassName="p-0 sm:p-4 hover:bg-primary-600/10"
                        >
                            <div className="flex flex-col sm:flex-row gap-4 sm:gap-6">
                                <img
                                    src={listing.animals[0].thumbnail}
                                    className="h-96 flex-none rounded-md rounded-b-none object-cover sm:size-52 sm:rounded-b-md"
                                    alt={`${listing.animals[0].thumbnail} thumbnail`}
                                />
                                <div className="flex-auto p-4 sm:p-0">
                                    <div className="flex items-baseline justify-between gap-4">
                                        <div className="w-full grid grid-cols-2 grid-rows-2">
                                            <p className="text-xl/9 font-semibold text-basic">
                                                {listing.animals[0].name}
                                            </p>

                                            <p className="flex items-end flex-col whitespace-nowrap">
                                                <span className="text-xs">
                                                    {tenant
                                                        ? ''
                                                        : listing.organisation
                                                              ?.name}
                                                </span>
                                                <span className="text-sm font-semibold">
                                                    Location
                                                </span>
                                            </p>

                                            <div className="flex gap-3 order-last col-span-2">
                                                <p className="flex flex-col">
                                                    <span className="text-sm">
                                                        Sex
                                                    </span>
                                                    <span className="font-semibold">
                                                        Female
                                                    </span>
                                                </p>
                                                <p className="flex flex-col">
                                                    <span className="text-sm">
                                                        Age
                                                    </span>
                                                    <span className="font-semibold">
                                                        1 Year
                                                    </span>
                                                </p>
                                                <p className="flex flex-col">
                                                    <span className="text-sm">
                                                        Size
                                                    </span>
                                                    <span className="font-semibold">
                                                        Small
                                                    </span>
                                                </p>
                                                <p className="flex flex-col">
                                                    <span className="text-sm">
                                                        Breed
                                                    </span>
                                                    <span className="font-semibold">
                                                        {
                                                            listing.animals[0]
                                                                .animalable
                                                                .breed
                                                        }
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <p className="mt-2 line-clamp-3 text-sm/6 text-basic">
                                        {listing.excerpt}
                                    </p>
                                </div>
                            </div>
                        </Card>
                    </Link>
                </li>
            ))}
        </ul>
    )
}
