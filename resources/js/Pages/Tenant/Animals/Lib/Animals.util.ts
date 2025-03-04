import { BadgeColor } from '@/Components/_Base/Badge'
import Animal = App.Models.Animal

export const badgeColor = (
    animal: Pick<Animal, 'published_at'>,
): BadgeColor => {
    return animal.published_at ? BadgeColor.SUCCESS : BadgeColor.SECONDARY
}

export const badgeLabelKey = (
    animal: Pick<Animal, 'published_at'>,
): TranslationKey => {
    return animal.published_at
        ? 'general.status.published'
        : 'general.status.unlisted'
}
