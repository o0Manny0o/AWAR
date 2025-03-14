import { twMerge } from 'tailwind-merge'
import { ChevronDownIcon } from '@heroicons/react/24/solid'
import { RouteName } from 'ziggy-js'
import { Link, router } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'

export function AnimalIndexTabs({ type }: { type: string }) {
    const __ = useTranslate()

    const tabs: { name: string; routeName: RouteName }[] = [
        { name: 'animals', routeName: `animals.${type}.index` },
        { name: 'listings', routeName: `animals.${type}.listings.index` },
    ]

    return (
        <div>
            <div className="grid grid-cols-1 sm:hidden">
                <select
                    defaultValue={
                        tabs.find((tab) => route().current(tab.routeName))
                            ?.routeName
                    }
                    onChange={(v) => {
                        router.visit(route(v.target.value))
                    }}
                    aria-label="Select a tab"
                    className="col-start-1 row-start-1 w-full appearance-none rounded-md bg-ceiling text-basic
                        py-2 pl-3 pr-8 text-base outline outline-1 -outline-offset-1 outline-gray-300
                        focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-primary-600"
                >
                    {tabs.map((tab) => (
                        <option key={tab.name} value={tab.routeName}>
                            {tab.name}
                        </option>
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
                            const current = route().current(tab.routeName)
                            return (
                                <Link
                                    key={tab.name}
                                    href={route(tab.routeName)}
                                    aria-current={current ? 'page' : undefined}
                                    className={twMerge(
                                        current
                                            ? 'border-primary-500 text-primary-600'
                                            : 'text-interactive border-transparent hover:border-gray-300',
                                        'whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium',
                                    )}
                                >
                                    {__(
                                        `animals.general.navigation.${tab.name}` as TranslationKey,
                                    )}
                                </Link>
                            )
                        })}
                    </nav>
                </div>
            </div>
        </div>
    )
}
