import { BadgeColor } from '@/Components/_Base/Badge'
import Animal = App.Models.Animal

export const badgeColor = (animal: Pick<Animal, 'isPublished'>): BadgeColor => {
    return animal.isPublished ? BadgeColor.SUCCESS : BadgeColor.SECONDARY
}

export const badgeLabelKey = (
    animal: Pick<Animal, 'isPublished'>,
): TranslationKey => {
    return animal.isPublished
        ? 'general.status.published'
        : 'general.status.unlisted'
}
