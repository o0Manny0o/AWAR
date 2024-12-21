import { Button } from '@/Components/_Base/Button'
import useTranslate from '@/shared/hooks/useTranslate'

export function SubmitButton({
    processing,
    label,
    ...props
}: {
    processing: boolean
    label?: string
    href?: string
}) {
    const __ = useTranslate()
    return (
        <Button {...props} className="w-full" disabled={processing}>
            {label ? label : __('general.button.continue')}
        </Button>
    )
}
