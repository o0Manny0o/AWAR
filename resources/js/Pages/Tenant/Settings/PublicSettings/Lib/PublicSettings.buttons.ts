import { PageHeaderButton } from '@/Components/Layout/PageHeader'
import useTranslate from '@/shared/hooks/useTranslate'
import usePermission from '@/shared/hooks/usePermission'
import { RouteName } from 'ziggy-js'
import PublicSettings = App.Models.Organisation.PublicSettings

export function ShowActionButtons(
    settings: PublicSettings,
    baseRouteName: RouteName,
): PageHeaderButton[] {
    const __ = useTranslate()
    const { canUpdate } = usePermission()

    const EDIT_BUTTON: PageHeaderButton = {
        label: __('general.button.edit', {
            resource: '',
        }),
        variant: 'secondary',
        href: route(baseRouteName + '.edit'),
    }

    const buttons = []

    if (canUpdate(settings)) {
        buttons.push(EDIT_BUTTON)
    }

    return buttons
}

export function FormActionButtons(
    cancelRoute: string,
    formId: string,
): PageHeaderButton[] {
    const __ = useTranslate()

    const SAVE_BUTTON: PageHeaderButton = {
        label: __('general.button.save', {
            resource: '',
        }),
        variant: 'primary',
        form: formId,
    }

    const CANCEL_BUTTON: PageHeaderButton = {
        label: __('general.button.cancel', {
            resource: '',
        }),
        variant: 'secondary',
        href: cancelRoute,
    }

    return [SAVE_BUTTON, CANCEL_BUTTON]
}
