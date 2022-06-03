// const loadMoreButtonHTML =`<button type="button" class="load-more btn btn-primary">載入更多</button>`
export const fromTemplate = `
    <form class="add-comment-form">
        <div class="form-group">
            <label for="content-nickname">暱稱</label>
            <input type="text" name="nickname" class="form-control" id="content-nickname">
            <label for="content-textarea">留言內容</label>
            <textarea name="content" class="form-control" id="content-textarea" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div class = "comments-list">
        <!-- card 放在這裡-->
    </div>
`
export const cssTemplate = `
    .comments-list {
        margin-bottom:40px;
    }

    .card {
        margin-top:16px;
    }

    .load-more {
        margin-top:16px;
    }
`
export function getLoadMoreButton(loadMoreClassName) {
  return `<button type="button" class="${loadMoreClassName} load-more btn btn-primary">載入更多</button>`
}

export function getForm(className, commentsClassName) {
  return `
    <form class="${className}">
        <div class="form-group">
            <label>暱稱</label>
            <input type = "text" name = "nickname" class = "form-control">
            <label>留言內容</label>
            <textarea name ="content" class = "form-control"  rows ="3"></textarea>
        </div>
        <button type = "submit" class = "btn btn-primary">Submit</button>
    </form>
    <div class = "${commentsClassName}">
        <!-- card 放在這裡-->
    </div>
`
}
