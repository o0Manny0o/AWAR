import { PropsWithChildren } from 'react'
import { PageHeaderProps } from '@/Components/Layout/PageHeader'
import { SidebarLayout } from '@/Layouts/SidebarLayout'
import {
    CentralNavigation,
    NextStep,
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
    const { tenant, nextSteps } = usePage().props

    // TODO: Refactor to get started page
    const navigation = tenant
        ? TenantNavigation
        : CentralNavigation([
              ...(nextSteps?.includes('selfDisclosure')
                  ? [NextStep.FINISH_DISCLOSURE.value]
                  : []),
          ])

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
