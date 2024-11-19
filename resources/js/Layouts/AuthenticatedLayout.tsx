import { PropsWithChildren, ReactNode } from 'react'
import { HeaderBar } from '@/Components/Layout/HeaderBar'
import {
    DesktopMainNav,
    DesktopSecondaryNav,
} from '@/Components/Layout/Desktop'
import AuthenticatedNavigation from '@/shared/_constants/AuthenticatedNavigation'
import { BellIcon } from '@heroicons/react/24/solid'
import { MobileMainNav } from '@/Components/Layout/Mobile'

export default function Authenticated({
    header,
    children,
}: PropsWithChildren<{ header?: ReactNode }>) {
    return (
        <div className="bg-floor min-h-screen">
            <HeaderBar
                mainNavigation={
                    <DesktopMainNav navigation={AuthenticatedNavigation} />
                }
                secondaryNavigation={
                    <DesktopSecondaryNav>
                        <button
                            type="button"
                            className="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500"
                        >
                            <span className="sr-only">View notifications</span>
                            <BellIcon aria-hidden="true" className="size-6" />
                        </button>
                    </DesktopSecondaryNav>
                }
                mobileNavigation={
                    <MobileMainNav navigation={AuthenticatedNavigation} />
                }
            />

            {header && (
                <header className="bg-ceiling">
                    <div className="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        {header}
                    </div>
                </header>
            )}

            <main className="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                {children}
            </main>
        </div>
    )
}
