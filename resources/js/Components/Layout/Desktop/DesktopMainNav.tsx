import useTranslate from '@/shared/hooks/useTranslate'
import DesktopNavLink from '@/Components/Layout/Desktop/DesktopNavLink'
import { NavigationItem } from '@/types/navigation'
import { PropsWithChildren } from 'react'

export default function DesktopMainNav({
    navigation,
    children,
}: PropsWithChildren<{
    navigation: NavigationItem[]
}>) {
    const __ = useTranslate()

    return (
        <div className="hidden sm:ml-6 sm:flex sm:space-x-4">
            {navigation.map((link) => (
                <DesktopNavLink
                    key={link.name}
                    href={route(link.name)}
                    active={route().current(link.name)}
                >
                    {__(link.label)}
                </DesktopNavLink>
            ))}
            {children}
        </div>
    )
}
