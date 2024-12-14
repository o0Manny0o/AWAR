import Location = App.Models.Location
import { BadgeColor } from '@/Components/_Base/Badge'

export const badgeColor = (
    application: Pick<Location, 'public' | 'deleted_at'>,
): BadgeColor => {
    if (application.deleted_at) {
        return BadgeColor.DANGER
    }
    return application.public ? BadgeColor.SUCCESS : BadgeColor.SECONDARY
}

export const badgeLabelKey = (
    application: Pick<Location, 'public' | 'deleted_at'>,
): TranslationKey => {
    return application.deleted_at
        ? 'general.deleted'
        : application.public
          ? 'general.status.public'
          : 'general.status.internal'
}
