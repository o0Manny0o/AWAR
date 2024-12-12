import { AnchorHTMLAttributes } from 'react'

export function Anchor(props: AnchorHTMLAttributes<HTMLAnchorElement>) {
    return <a {...props}>{props.children}</a>
}
