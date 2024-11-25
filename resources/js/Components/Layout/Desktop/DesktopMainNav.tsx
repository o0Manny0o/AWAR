import useTranslate from '@/shared/hooks/useTranslate'
import DesktopNavLink from '@/Components/Layout/Desktop/DesktopNavLink'
import { NavigationItem } from '@/types/navigation'

export default function DesktopMainNav({
    navigation,
}: {
    navigation: NavigationItem[]
}) {
    const __ = useTranslate()

    return (
        <div className="hidden sm:ml-6 sm:flex sm:space-x-4">
            {navigation.map((link) => (
                <DesktopNavLink
                    key={link.name}
                    href={route(link.routeName)}
                    active={route().current(link.routeName)}
                >
                    {__(link.label)}
                </DesktopNavLink>
            ))}
        </div>
    )
}
