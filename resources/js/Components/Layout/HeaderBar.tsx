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

export function HeaderBar() {
    const { auth } = usePage().props
    const __ = useTranslate()

    return (
        <Disclosure as="nav" className="bg-ceiling border-base border-b">
            <div className="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
                <div className="relative flex h-16 justify-between">
                    <div className="absolute inset-y-0 left-0 flex items-center sm:hidden">
                        {/* Mobile menu button */}
                        <DisclosureButton className="text-inactive focus:ring-primary-500 group relative inline-flex items-center justify-center rounded-md p-2 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset">
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
                            <svg
                                className="h-8 w-auto"
                                width="78"
                                height="30"
                                viewBox="0 0 78 30"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <g clip-path="url(#clip0_16_413)">
                                    <path
                                        d="M18.5147 0C15.4686 0 12.5473 1.21005 10.3934 3.36396L3.36396 10.3934C1.21005 12.5473 0 15.4686 0 18.5147C0 24.8579 5.14214 30 11.4853 30C14.5314 30 17.4527 28.7899 19.6066 26.636L24.4689 21.7737C24.4689 21.7736 24.469 21.7738 24.4689 21.7737L38.636 7.6066C39.6647 6.57791 41.0599 6 42.5147 6C44.9503 6 47.0152 7.58741 47.7311 9.78407L52.2022 5.31296C50.1625 2.11834 46.586 0 42.5147 0C39.4686 0 36.5473 1.21005 34.3934 3.36396L15.364 22.3934C14.3353 23.4221 12.9401 24 11.4853 24C8.45584 24 6 21.5442 6 18.5147C6 17.0599 6.57791 15.6647 7.6066 14.636L14.636 7.6066C15.6647 6.57791 17.0599 6 18.5147 6C20.9504 6 23.0152 7.58748 23.7311 9.78421L28.2023 5.31307C26.1626 2.1184 22.5861 0 18.5147 0Z"
                                        fill="currentColor"
                                    />
                                    <path
                                        d="M39.3639 22.3934C38.3352 23.4221 36.94 24 35.4852 24C33.0499 24 30.9852 22.413 30.2691 20.2167L25.7981 24.6877C27.8379 27.8819 31.4142 30 35.4852 30C38.5313 30 41.4526 28.7899 43.6065 26.636L62.6359 7.6066C63.6646 6.57791 65.0598 6 66.5146 6C69.5441 6 71.9999 8.45584 71.9999 11.4853C71.9999 12.9401 71.422 14.3353 70.3933 15.364L63.3639 22.3934C62.3352 23.4221 60.94 24 59.4852 24C57.0497 24 54.9849 22.4127 54.2689 20.2162L49.7979 24.6873C51.8376 27.8818 55.414 30 59.4852 30C62.5313 30 65.4526 28.7899 67.6065 26.636L74.6359 19.6066C76.7898 17.4527 77.9999 14.5314 77.9999 11.4853C77.9999 5.14214 72.8578 0 66.5146 0C63.4685 0 60.5472 1.21005 58.3933 3.36396L39.3639 22.3934Z"
                                        fill="currentColor"
                                    />
                                </g>
                                <defs>
                                    <clipPath id="clip0_16_413">
                                        <rect
                                            width="78"
                                            height="30"
                                            fill="white"
                                        />
                                    </clipPath>
                                </defs>
                            </svg>
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
                                        <MenuButton className="text-inactive dark:focus:bg-gray-70 relative flex items-center border-b-2 border-transparent px-3 pt-1 text-sm font-medium hover:border-gray-300 dark:hover:border-gray-600">
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
                        className="border-primary-500 bg-primary-50 text-primary-700 block border-l-4 py-2 pl-3 pr-4 text-base font-medium"
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
