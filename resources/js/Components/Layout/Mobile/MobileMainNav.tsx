import useTranslate from '@/shared/hooks/useTranslate'
import MobileNavLink from '@/Components/Layout/Mobile/MobileNavLink'
import { NavigationItem } from '@/types/navigation'
import { Branding } from '@/Components/Layout/Branding'

export default function MobileMainNav({
    navigation,
}: {
    navigation: NavigationItem[]
}) {
    const __ = useTranslate()

    return (
        <div className="bg-ceiling flex grow flex-col gap-y-5 overflow-y-auto px-6 pb-4">
            <div className="flex h-16 shrink-0 items-center">
                <Branding />
            </div>
            <nav className="flex flex-1 flex-col">
                <ul role="list" className="flex-1 space-y-4 font-semibold">
                    {navigation.map((link) => (
                        <li key={link.name}>
                            <MobileNavLink
                                href={route(link.name)}
                                active={route().current(link.name)}
                            >
                                {__(link.label)}
                            </MobileNavLink>
                        </li>
                    ))}
                </ul>
            </nav>
        </div>
    )
}
