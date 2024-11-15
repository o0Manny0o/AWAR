import { HeaderBar } from '@/Components/Layout/HeaderBar'
import { PropsWithChildren } from 'react'

export default function Guest({ children }: PropsWithChildren) {
    return (
        <div className="bg-floor min-h-screen">
            <HeaderBar />

            <main>{children}</main>
        </div>
    )
}
