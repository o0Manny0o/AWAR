import { PageHeaderButton } from '@/Components/Layout/PageHeader'
import useTranslate from '@/shared/hooks/useTranslate'
import usePermission from '@/shared/hooks/usePermission'
import { RouteName } from 'ziggy-js'

export function ShowActionButtons(
    resource: TranslationKey,
    routeName: RouteName,
): PageHeaderButton[] {
    const __ = useTranslate()
    const { can } = usePermission()

    return can('animals.create')
        ? [
              {
                  label: __('general.button.new', {
                      resource,
                  }),
                  variant: 'primary',
                  href: route(routeName),
              },
          ]
        : []
}

export function EditActionButtons(
    indexRouteName: RouteName,
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
        href: route(indexRouteName),
    }

    return [SAVE_BUTTON, CANCEL_BUTTON]
}
