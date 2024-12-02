import ApplicationLogo from '@/Components/ApplicationLogo'
import { Link } from '@inertiajs/react'
import { PropsWithChildren } from 'react'
import { BaseLayout } from '@/Layouts/BaseLayout'
import { Card } from '@/Components/Layout/Card'

export default function GuestFlow({ children }: PropsWithChildren) {
    return (
        <BaseLayout>
            <div
                className="fixed left-1/2 top-[min(20vh,256px)] w-full max-w-xl -translate-x-1/2 flex
                    flex-col items-center"
            >
                <div>
                    <Link href="/">
                        <ApplicationLogo className="h-20 w-20 fill-current text-gray-500" />
                    </Link>
                </div>

                <Card className="mt-6">{children}</Card>
            </div>
        </BaseLayout>
    )
}
