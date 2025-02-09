import { twMerge } from 'tailwind-merge'
import { ChevronDownIcon } from '@heroicons/react/24/solid'
import { RouteName } from 'ziggy-js'
import { Link } from '@inertiajs/react'

export function AnimalIndexTabs({ type }: { type: string }) {
    const tabs: { name: string; routeName: RouteName }[] = [
        { name: 'animals', routeName: `animals.${type}.index` },
        { name: 'listings', routeName: `animals.listings.${type}.index` },
    ]

    return (
        <div>
            <div className="grid grid-cols-1 sm:hidden">
                <select
                    defaultValue={
                        tabs.find((tab) => route().current(tab.routeName))?.name
                    }
                    aria-label="Select a tab"
                    className="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pl-3
                        pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1
                        outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2
                        focus:outline-indigo-600"
                >
                    {tabs.map((tab) => (
                        <option key={tab.name}>{tab.name}</option>
                    ))}
                </select>
                <ChevronDownIcon
                    aria-hidden="true"
                    className="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center
                        justify-self-end fill-gray-500"
                />
            </div>
            <div className="hidden sm:block">
                <div className="border-b border-gray-200">
                    <nav aria-label="Tabs" className="-mb-px flex space-x-8">
                        {tabs.map((tab) => {
                            const current = route().current(tab.name)
                            return (
                                <Link
                                    key={tab.name}
                                    href={route(tab.routeName)}
                                    aria-current={current ? 'page' : undefined}
                                    className={twMerge(
                                        current
                                            ? 'border-indigo-500 text-indigo-600'
                                            : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                                        'whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium',
                                    )}
                                >
                                    {tab.name}
                                </Link>
                            )
                        })}
                    </nav>
                </div>
            </div>
        </div>
    )
}
