import { PropsWithChildren } from 'react'

export function BaseLayout({ children }: PropsWithChildren) {
    return <div className="bg-floor min-h-screen">{children}</div>
}
