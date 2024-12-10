import { useMemo } from 'react'
import Animal = App.Models.Animal

export default function useAnimalOptions(
    animals: Animal[],
    self?: { name: string; sex: 'male' | 'female' },
) {
    const females: Animal[] = useMemo(
        () => [
            { id: '', name: 'Unknown' } as Animal,
            ...(self?.sex === 'female'
                ? [
                      {
                          id: '0',
                          name: self.name,
                      } as Animal,
                  ]
                : []),
            ...animals.filter((a) => a.sex === 'female'),
        ],
        [self?.name, self?.sex, animals],
    )
    const males: Animal[] = useMemo(
        () => [
            { id: '', name: 'Unknown' } as Animal,
            ...(self?.sex === 'male'
                ? [
                      {
                          id: '0',
                          name: self.name,
                      } as Animal,
                  ]
                : []),
            ...animals.filter((a) => a.sex === 'male'),
        ],
        [self?.name, self?.sex, animals],
    )

    return {
        females,
        males,
    }
}
