import useTranslate from '@/shared/hooks/useTranslate'
import DesktopNavLink from '@/Components/Layout/Desktop/DesktopNavLink'
import PublicNavigation from '@/shared/_constants/PublicNavigation'

export default function DesktopMainNav() {
    const __ = useTranslate()

    return (
        <div className="hidden sm:ml-6 sm:flex sm:space-x-4">
            {PublicNavigation.map((link) => (
                <DesktopNavLink
                    href={route(link.routeName)}
                    active={route().current(link.routeName)}
                >
                    {__(link.label)}
                </DesktopNavLink>
            ))}
        </div>
    )
}
