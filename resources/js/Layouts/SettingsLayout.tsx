import { PageHeaderProps } from '@/Components/Layout/PageHeader'
import { PropsWithChildren } from 'react'
import { SidebarLayout } from '@/Layouts/SidebarLayout'
import { usePage } from '@inertiajs/react'
import {
    CentralSettingsNavigation,
    TenantSettingsNavigation,
} from '@/shared/_constants/SettingsNavigation'

export function SettingsLayout({
    children,
    title,
    ...pageHeaderProps
}: PropsWithChildren<{ title: string } & PageHeaderProps>) {
    const { tenant } = usePage().props

    // Organisation settings nav or personal settings nav
    const navigation = tenant
        ? TenantSettingsNavigation
        : CentralSettingsNavigation

    return (
        <SidebarLayout
            navigation={navigation}
            title={title}
            showOrganisations={false}
            isSettings
            {...pageHeaderProps}
        >
            {children}
        </SidebarLayout>
    )
}
