import { PropsWithChildren } from 'react'
import { PageHeaderProps } from '@/Components/Layout/PageHeader'
import { SidebarLayout } from '@/Layouts/SidebarLayout'
import {
    CentralNavigation,
    TenantNavigation,
} from '@/shared/_constants/AuthenticatedNavigation'
import { usePage } from '@inertiajs/react'

export type AuthenticatedLayoutProps = PropsWithChildren<
    { title: string } & PageHeaderProps
>

export default function AuthenticatedLayout({
    children,
    title,
    ...pageHeaderProps
}: AuthenticatedLayoutProps) {
    const { tenant } = usePage().props

    const navigation = tenant ? TenantNavigation : CentralNavigation

    return (
        <SidebarLayout
            navigation={navigation}
            title={title}
            {...pageHeaderProps}
        >
            {children}
        </SidebarLayout>
    )
}
