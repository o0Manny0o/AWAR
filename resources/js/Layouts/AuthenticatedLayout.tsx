import { PropsWithChildren, useState } from 'react'
import { MagnifyingGlassIcon } from '@heroicons/react/24/solid'
import { BaseLayout } from '@/Layouts/BaseLayout'
import {
    Dialog,
    DialogBackdrop,
    DialogPanel,
    TransitionChild,
} from '@headlessui/react'
import { Bars3Icon, XMarkIcon } from '@heroicons/react/24/outline'
import { DesktopSecondaryNav } from '@/Components/Layout/Desktop'
import { SidebarNav } from '@/Components/Layout/Sidebar/SidebarNav'
import useTranslate from '@/shared/hooks/useTranslate'
import PageHeader, { PageHeaderProps } from '@/Components/Layout/PageHeader'

export default function Authenticated({
    children,
    ...pageHeaderProps
}: PropsWithChildren<PageHeaderProps>) {
    const __ = useTranslate()

    const [sidebarOpen, setSidebarOpen] = useState(false)

    return (
        <BaseLayout>
            <div>
                <Dialog
                    open={sidebarOpen}
                    onClose={setSidebarOpen}
                    className="relative z-50 lg:hidden"
                >
                    <DialogBackdrop
                        transition
                        className="fixed inset-0 bg-gray-900/80 transition-opacity duration-300 ease-linear
                            data-[closed]:opacity-0"
                    />

                    <div className="fixed inset-0 flex">
                        <DialogPanel
                            transition
                            className="relative mr-16 flex w-full max-w-xs flex-1 transform transition duration-300
                                ease-in-out data-[closed]:-translate-x-full"
                        >
                            <TransitionChild>
                                <div
                                    className="absolute left-full top-0 flex w-16 justify-center pt-5 duration-300 ease-in-out
                                        data-[closed]:opacity-0"
                                >
                                    <button
                                        type="button"
                                        onClick={() => setSidebarOpen(false)}
                                        className="-m-2.5 p-2.5 text-interactive"
                                    >
                                        <span className="sr-only">
                                            {__('general.layout.close_sidebar')}
                                        </span>
                                        <XMarkIcon
                                            aria-hidden="true"
                                            className="size-6"
                                        />
                                    </button>
                                </div>
                            </TransitionChild>

                            <SidebarNav />
                        </DialogPanel>
                    </div>
                </Dialog>

                <div className="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
                    <SidebarNav />
                </div>

                <div className="lg:pl-72">
                    <div
                        className="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-2 border-b
                            border-gray-200 dark:border-gray-700 bg-ceiling px-4 shadow-sm sm:gap-x-6
                            sm:px-6 lg:px-8"
                    >
                        <button
                            type="button"
                            onClick={() => setSidebarOpen(true)}
                            className="-m-2.5 p-2.5 text-interactive lg:hidden"
                        >
                            <span className="sr-only">
                                {__('general.layout.open_sidebar')}
                            </span>
                            <Bars3Icon aria-hidden="true" className="size-6" />
                        </button>

                        <div
                            aria-hidden="true"
                            className="h-6 w-px dark:bg-gray-400 bg-gray-900/10 lg:hidden"
                        />

                        <div className="flex flex-1 self-stretch">
                            <form
                                action="#"
                                method="GET"
                                className="grid flex-1 grid-cols-1"
                            >
                                <input
                                    name="search"
                                    type="search"
                                    placeholder="Search"
                                    aria-label="Search"
                                    className="col-start-1 row-start-1 block size-full bg-ceiling pl-8 text-base text-basic
                                        outline-none placeholder:text-gray-400 sm:text-sm/6 border-0"
                                />
                                <MagnifyingGlassIcon
                                    aria-hidden="true"
                                    className="pointer-events-none col-start-1 row-start-1 size-5 self-center text-gray-400"
                                />
                            </form>
                        </div>

                        <div
                            aria-hidden="true"
                            className="h-6 w-px dark:bg-gray-400 bg-gray-900/10 lg:hidden"
                        />
                        <div className="flex self-stretch">
                            <DesktopSecondaryNav />
                        </div>
                    </div>

                    <main className="py-8 px-2 sm:px-6 lg:px-8">
                        <PageHeader {...pageHeaderProps} />
                        {children}
                    </main>
                </div>
            </div>
        </BaseLayout>
    )
}
