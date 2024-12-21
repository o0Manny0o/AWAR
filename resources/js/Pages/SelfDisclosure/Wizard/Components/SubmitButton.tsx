import { Button } from '@/Components/_Base/Button'
import useTranslate from '@/shared/hooks/useTranslate'
import { Method } from '@inertiajs/core'

export function SubmitButton({
    processing,
    label,
    ...props
}: {
    processing: boolean
    label?: string
    href?: string
    method?: Method
}) {
    const __ = useTranslate()
    return (
        <Button {...props} className="w-full" disabled={processing}>
            {label ? label : __('general.button.continue')}
        </Button>
    )
}
