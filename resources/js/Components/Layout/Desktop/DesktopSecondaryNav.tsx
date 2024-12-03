import useTranslate from '@/shared/hooks/useTranslate'
import DesktopNavLink from '@/Components/Layout/Desktop/DesktopNavLink'
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/react'
import { usePage } from '@inertiajs/react'
import { MenuItemLink } from '@/Components/_Base'
import { PropsWithChildren } from 'react'
import { getAbbreviation } from '@/shared/util'

export default function DesktopMainNav({ children }: PropsWithChildren) {
    const __ = useTranslate()
    const { auth, centralDomain } = usePage().props

    return (
        <div className="right-0 flex sm:static sm:pr-0">
            {auth.user ? (
                <>
                    {children}
                    <Menu as="div" className="relative">
                        <div className="flex h-full">
                            <MenuButton
                                className="text-interactive border-interactive bg-interactive relative flex items-center
                                    border-b-2 px-3 pt-1 text-sm font-medium"
                            >
                                <span className="sr-only">
                                    {__('general.layout.open_user_menu')}
                                </span>

                                <span className="hidden sm:inline-block">
                                    {auth.user.name}
                                </span>
                                <span className="sm:hidden">
                                    {getAbbreviation(auth.user.name)}
                                </span>

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
                            className="bg-ceiling absolute right-0 z-10 w-48 origin-top-right rounded-md py-1 shadow-lg
                                ring-1 ring-black/5 transition focus:outline-none data-[closed]:scale-95
                                data-[closed]:transform data-[closed]:opacity-0 data-[enter]:duration-200
                                data-[leave]:duration-75 data-[enter]:ease-out data-[leave]:ease-in"
                        >
                            <MenuItem>
                                <MenuItemLink
                                    component={function Anchor(props) {
                                        return (
                                            <a {...props}>{props.children}</a>
                                        )
                                    }}
                                    href={`https://${centralDomain}/dashboard`}
                                    active={route().current('dashboard')}
                                >
                                    {__('general.navigation.your_dashboard')}
                                </MenuItemLink>
                            </MenuItem>
                            <MenuItem>
                                <MenuItemLink href={route('profile.edit')}>
                                    {__('general.navigation.profile')}
                                </MenuItemLink>
                            </MenuItem>
                            <MenuItem>
                                <MenuItemLink
                                    href={route('logout', {}, false)}
                                    method="post"
                                    as="button"
                                >
                                    {__('general.navigation.logout')}
                                </MenuItemLink>
                            </MenuItem>
                        </MenuItems>
                    </Menu>
                </>
            ) : (
                <>
                    <DesktopNavLink
                        href={route('login', {}, false)}
                        active={route().current('login')}
                    >
                        {__('general.navigation.login')}
                    </DesktopNavLink>
                    <DesktopNavLink
                        href={route('register', {}, false)}
                        active={route().current('register')}
                    >
                        {__('general.navigation.register')}
                    </DesktopNavLink>
                </>
            )}
        </div>
    )
}
