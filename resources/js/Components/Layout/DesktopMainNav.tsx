import DesktopNavLink from '@/Components/Layout/DesktopNavLink'

export function DesktopMainNav() {
    return (
        <div className="hidden sm:ml-6 sm:flex sm:space-x-8">
            <DesktopNavLink
                href={route('about')}
                active={route().current('about')}
            >
                About
            </DesktopNavLink>
        </div>
    )
}
