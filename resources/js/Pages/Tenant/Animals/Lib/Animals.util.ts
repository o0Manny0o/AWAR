import { BadgeColor } from '@/Components/_Base/Badge'
import Animal = App.Models.Animal

export const badgeColor = (
    application: Pick<Animal, 'published_at'>,
): BadgeColor => {
    return application.published_at ? BadgeColor.SUCCESS : BadgeColor.SECONDARY
}

export const badgeLabelKey = (
    application: Pick<Animal, 'published_at'>,
): TranslationKey => {
    return application.published_at
        ? 'general.status.published'
        : 'general.status.unlisted'
}
