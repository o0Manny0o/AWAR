import {
    Dialog,
    DialogBackdrop,
    DialogPanel,
    Disclosure,
    TransitionChild,
} from '@headlessui/react'
import { Bars3Icon, XMarkIcon } from '@heroicons/react/24/outline'
import { Link } from '@inertiajs/react'
import useTranslate from '@/shared/hooks/useTranslate'
import {
    DesktopMainNav,
    DesktopSecondaryNav,
} from '@/Components/Layout/Desktop'
import { Logo } from '@/Components/Layout/Logo'
import { useState } from 'react'
import { MobileMainNav } from '@/Components/Layout/Mobile'

export function HeaderBar() {
    const __ = useTranslate()

    const [sidebarOpen, setSidebarOpen] = useState(false)

    return (
        <div>
            <Disclosure as="nav" className="bg-ceiling border-base border-b">
                <div className="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
                    <div className="relative flex h-16 justify-between">
                        <div className="absolute inset-y-0 left-0 flex items-center sm:hidden">
                            <button
                                onClick={() => setSidebarOpen(true)}
                                className="text-interactive group relative inline-flex items-center justify-center rounded-md p-2"
                            >
                                <span className="absolute -inset-0.5" />
                                <span className="sr-only">
                                    {__('general.layout.open_sidebar')}
                                </span>
                                <Bars3Icon
                                    aria-hidden="true"
                                    className="block size-6 group-data-[open]:hidden"
                                />
                                <XMarkIcon
                                    aria-hidden="true"
                                    className="hidden size-6 group-data-[open]:block"
                                />
                            </button>
                        </div>
                        <div className="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                            <Link
                                href="/"
                                className="hidden shrink-0 items-center hover:text-primary-600 focus:text-primary-600 sm:flex dark:hover:text-primary-400 dark:focus:text-primary-400"
                            >
                                <Logo className="h-8 w-auto" />
                            </Link>
                            <DesktopMainNav />
                        </div>
                        <DesktopSecondaryNav />
                    </div>
                </div>
            </Disclosure>
            <Dialog
                open={sidebarOpen}
                onClose={setSidebarOpen}
                className="relative z-50 sm:hidden"
            >
                <DialogBackdrop
                    transition
                    className="fixed inset-0 bg-gray-900/80 transition-opacity duration-300 ease-linear data-[closed]:opacity-0"
                />

                <div className="fixed inset-0 flex">
                    <DialogPanel
                        transition
                        className="relative mr-16 flex w-full max-w-xs flex-1 transform transition duration-300 ease-in-out data-[closed]:-translate-x-full"
                    >
                        <TransitionChild>
                            <div className="absolute left-full top-0 flex w-16 justify-center pt-5 duration-300 ease-in-out data-[closed]:opacity-0">
                                <button
                                    type="button"
                                    onClick={() => setSidebarOpen(false)}
                                    className="-m-2.5 p-2.5"
                                >
                                    <span className="sr-only">
                                        {__('general.layout.close_sidebar')}
                                    </span>
                                    <XMarkIcon
                                        aria-hidden="true"
                                        className="size-6 text-white"
                                    />
                                </button>
                            </div>
                        </TransitionChild>
                        <MobileMainNav />
                    </DialogPanel>
                </div>
            </Dialog>
        </div>
    )
}
