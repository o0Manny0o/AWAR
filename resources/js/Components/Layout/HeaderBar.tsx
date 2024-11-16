import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
} from '@headlessui/react'
import { Bars3Icon, XMarkIcon } from '@heroicons/react/24/outline'
import { DesktopMainNav } from '@/Components/Layout/DesktopMainNav'
import { Link, usePage } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import DesktopNavLink from '@/Components/Layout/DesktopNavLink'
import { Logo } from '@/Components/Layout/Logo'

export function HeaderBar() {
    const { auth } = usePage().props
    const __ = useTranslate()

    return (
        <Disclosure as="nav" className="bg-ceiling border-base border-b">
            <div className="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
                <div className="relative flex h-16 justify-between">
                    <div className="absolute inset-y-0 left-0 flex items-center sm:hidden">
                        {/* Mobile menu button */}
                        <DisclosureButton className="text-interactive group relative inline-flex items-center justify-center rounded-md p-2 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                            <span className="absolute -inset-0.5" />
                            <span className="sr-only">Open main menu</span>
                            <Bars3Icon
                                aria-hidden="true"
                                className="block size-6 group-data-[open]:hidden"
                            />
                            <XMarkIcon
                                aria-hidden="true"
                                className="hidden size-6 group-data-[open]:block"
                            />
                        </DisclosureButton>
                    </div>
                    <div className="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                        <Link href="/" className="flex shrink-0 items-center">
                            <Logo className="h-8 w-auto" />
                        </Link>
                        <DesktopMainNav />
                    </div>
                    <div className="absolute inset-y-0 right-0 flex pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                        {auth.user ? (
                            <>
                                <DesktopNavLink href={route('dashboard')}>
                                    {__('general.navigation.dashboard')}
                                </DesktopNavLink>
                                <Menu as="div" className="relative ml-3">
                                    <div className="flex h-full">
                                        <MenuButton className="text-interactive dark:focus:bg-gray-70 relative flex items-center border-b-2 border-transparent px-3 pt-1 text-sm font-medium hover:border-gray-300 dark:hover:border-gray-600">
                                            <span className="sr-only">
                                                Open user menu
                                            </span>

                                            {auth.user.name}

                                            <svg
                                                className="-me-0.5 ms-2 h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fillRule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clipRule="evenodd"
                                                />
                                            </svg>
                                        </MenuButton>
                                    </div>
                                    <MenuItems
                                        transition
                                        className="absolute right-0 z-10 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 transition focus:outline-none data-[closed]:scale-95 data-[closed]:transform data-[closed]:opacity-0 data-[enter]:duration-200 data-[leave]:duration-75 data-[enter]:ease-out data-[leave]:ease-in"
                                    >
                                        <MenuItem>
                                            <Link
                                                href={route('profile.edit')}
                                                className="block px-4 py-2 text-sm text-gray-700 data-[focus]:bg-gray-100 data-[focus]:outline-none"
                                            >
                                                {__(
                                                    'general.navigation.profile',
                                                )}
                                            </Link>
                                        </MenuItem>
                                        <MenuItem>
                                            <Link
                                                href={route('logout')}
                                                method="post"
                                                as="button"
                                                className="block w-full px-4 py-2 text-left text-sm text-gray-700 data-[focus]:bg-gray-100 data-[focus]:outline-none"
                                            >
                                                {__(
                                                    'general.navigation.logout',
                                                )}
                                            </Link>
                                        </MenuItem>
                                    </MenuItems>
                                </Menu>
                            </>
                        ) : (
                            <>
                                <DesktopNavLink href={route('login')}>
                                    {__('general.navigation.login')}
                                </DesktopNavLink>
                                <DesktopNavLink
                                    href={route('register')}
                                    className="hidden sm:inline-flex"
                                >
                                    {__('general.navigation.register')}
                                </DesktopNavLink>
                            </>
                        )}
                    </div>
                </div>
            </div>

            <DisclosurePanel className="sm:hidden">
                <div className="space-y-1 pb-3 pt-2">
                    {/* Current: "bg-primary-50 border-primary-500 text-primary-700", Default: "border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700" */}
                    <DisclosureButton
                        as="a"
                        href="#"
                        className="block border-l-4 border-primary-500 bg-primary-50 py-2 pl-3 pr-4 text-base font-medium text-primary-700"
                    >
                        Dashboard
                    </DisclosureButton>
                    <DisclosureButton
                        as="a"
                        href="#"
                        className="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700"
                    >
                        Team
                    </DisclosureButton>
                </div>
            </DisclosurePanel>
        </Disclosure>
    )
}
