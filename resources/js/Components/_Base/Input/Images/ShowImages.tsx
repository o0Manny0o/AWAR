import Animal = App.Models.Animal

export function ShowImages({ animal }: { animal: Animal }) {
    return (
        <div className="flex gap-4 flex-wrap">
            {animal.gallery?.map((image, index) => (
                <img
                    className="w-32 h-32 object-cover rounded-md"
                    alt={`${animal.name} image ${index + 1}`}
                    key={index}
                    src={image}
                />
            ))}
        </div>
    )
}
