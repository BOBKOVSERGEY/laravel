<div class="form-group">
    <input type="text" class="form-control" name="title" placeholder="Введите заголовок" required value="{{ old('title') ?? $post->title ?? '' }}">
</div>
<div class="form-group">
    <textarea name="description" rows="10" class="form-control" placeholder="Введите описание" required>{{ old('description') ?? $post->description ?? '' }}</textarea>
</div>
<div class="form-group">
    <input type="file" name="img">
</div>
