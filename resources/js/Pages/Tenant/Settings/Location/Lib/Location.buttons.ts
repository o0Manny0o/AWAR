import { PageHeaderButton } from '@/Components/Layout/PageHeader'
import useTranslate from '@/shared/hooks/useTranslate'
import usePermission from '@/shared/hooks/usePermission'
import { RouteName } from 'ziggy-js'
import { usePage } from '@inertiajs/react'
import Location = App.Models.Location

export function IndexActionButtons(
    resource: TranslationKey,
    createRouteName: RouteName,
): PageHeaderButton[] {
    const __ = useTranslate()
    const { canCreate } = usePage().props

    return canCreate
        ? [
              {
                  label: __('general.button.new', {
                      resource,
                  }),
                  variant: 'primary',
                  href: route(createRouteName),
              },
          ]
        : []
}

export function ShowActionButtons(
    location: Location,
    resource: TranslationKey,
    baseRouteName: RouteName,
): PageHeaderButton[] {
    const __ = useTranslate()
    const { canUpdate, canDelete } = usePermission()

    const EDIT_BUTTON: PageHeaderButton = {
        label: __('general.button.edit', {
            resource: '',
        }),
        variant: 'secondary',
        href: route(baseRouteName + '.edit', location.id),
    }

    const DELETE_BUTTON: PageHeaderButton = {
        label: __('general.button.delete', {
            resource: '',
        }),
        variant: 'danger',
        method: 'delete',
        href: route(baseRouteName + '.destroy', location.id),
    }

    const buttons = []

    if (canUpdate(location)) {
        buttons.push(EDIT_BUTTON)
    }
    if (canDelete(location)) {
        buttons.push(DELETE_BUTTON)
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
