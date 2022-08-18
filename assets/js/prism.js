/* http://prismjs.com/download.html?themes=prism&languages=markup */
var _self =
    'undefined' != typeof window
      ? window
      : 'undefined' != typeof WorkerGlobalScope &&
        self instanceof WorkerGlobalScope
      ? self
      : {},
  Prism = (function () {
    var e = /\blang(?:uage)?-(\w+)\b/i,
      t = 0,
      n = (_self.Prism = {
        util: {
          encode: function (e) {
            return e instanceof a
              ? new a(e.type, n.util.encode(e.content), e.alias)
              : 'Array' === n.util.type(e)
              ? e.map(n.util.encode)
              : e
                  .replace(/&/g, '&amp;')
                  .replace(/</g, '&lt;')
                  .replace(/\u00a0/g, ' ')
          },
          type: function (e) {
            return Object.prototype.toString
              .call(e)
              .match(/\[object (\w+)\]/)[1]
          },
          objId: function (e) {
            return (
              e.__id || Object.defineProperty(e, '__id', { value: ++t }), e.__id
            )
          },
          clone: function (e) {
            var t = n.util.type(e)
            switch (t) {
              case 'Object':
                var a = {}
                for (var r in e)
                  e.hasOwnProperty(r) && (a[r] = n.util.clone(e[r]))
                return a
              case 'Array':
                return (
                  e.map &&
                  e.map(function (e) {
                    return n.util.clone(e)
                  })
                )
            }
            return e
          }
        },
        languages: {
          extend: function (e, t) {
            var a = n.util.clone(n.languages[e])
            for (var r in t) a[r] = t[r]
            return a
          },
          insertBefore: function (e, t, a, r) {
            r = r || n.languages
            var l = r[e]
            if (2 == arguments.length) {
              a = arguments[1]
              for (var i in a) a.hasOwnProperty(i) && (l[i] = a[i])
              return l
            }
            var o = {}
            for (var s in l)
              if (l.hasOwnProperty(s)) {
                if (s == t)
                  for (var i in a) a.hasOwnProperty(i) && (o[i] = a[i])
                o[s] = l[s]
              }
            return (
              n.languages.DFS(n.languages, function (t, n) {
                n === r[e] && t != e && (this[t] = o)
              }),
              (r[e] = o)
            )
          },
          DFS: function (e, t, a, r) {
            r = r || {}
            for (var l in e)
              e.hasOwnProperty(l) &&
                (t.call(e, l, e[l], a || l),
                'Object' !== n.util.type(e[l]) || r[n.util.objId(e[l])]
                  ? 'Array' !== n.util.type(e[l]) ||
                    r[n.util.objId(e[l])] ||
                    ((r[n.util.objId(e[l])] = !0),
                    n.languages.DFS(e[l], t, l, r))
                  : ((r[n.util.objId(e[l])] = !0),
                    n.languages.DFS(e[l], t, null, r)))
          }
        },
        plugins: {},
        highlightAll: function (e, t) {
          var a = {
            callback: t,
            selector:
              'code[class*="language-"], [class*="language-"] code, code[class*="lang-"], [class*="lang-"] code'
          }
          n.hooks.run('before-highlightall', a)
          for (
            var r,
              l = a.elements || document.querySelectorAll(a.selector),
              i = 0;
            (r = l[i++]);

          )
            n.highlightElement(r, e === !0, a.callback)
        },
        highlightElement: function (t, a, r) {
          for (var l, i, o = t; o && !e.test(o.className); ) o = o.parentNode
          o &&
            ((l = (o.className.match(e) || [, ''])[1]), (i = n.languages[l])),
            (t.className =
              t.className.replace(e, '').replace(/\s+/g, ' ') +
              ' language-' +
              l),
            (o = t.parentNode),
            /pre/i.test(o.nodeName) &&
              (o.className =
                o.className.replace(e, '').replace(/\s+/g, ' ') +
                ' language-' +
                l)
          var s = t.textContent,
            u = { element: t, language: l, grammar: i, code: s }
          if (!s || !i) return n.hooks.run('complete', u), void 0
          if ((n.hooks.run('before-highlight', u), a && _self.Worker)) {
            var c = new Worker(n.filename)
            ;(c.onmessage = function (e) {
              ;(u.highlightedCode = e.data),
                n.hooks.run('before-insert', u),
                (u.element.innerHTML = u.highlightedCode),
                r && r.call(u.element),
                n.hooks.run('after-highlight', u),
                n.hooks.run('complete', u)
            }),
              c.postMessage(
                JSON.stringify({
                  language: u.language,
                  code: u.code,
                  immediateClose: !0
                })
              )
          } else
            (u.highlightedCode = n.highlight(u.code, u.grammar, u.language)),
              n.hooks.run('before-insert', u),
              (u.element.innerHTML = u.highlightedCode),
              r && r.call(t),
              n.hooks.run('after-highlight', u),
              n.hooks.run('complete', u)
        },
        highlight: function (e, t, r) {
          var l = n.tokenize(e, t)
          return a.stringify(n.util.encode(l), r)
        },
        tokenize: function (e, t) {
          var a = n.Token,
            r = [e],
            l = t.rest
          if (l) {
            for (var i in l) t[i] = l[i]
            delete t.rest
          }
          e: for (var i in t)
            if (t.hasOwnProperty(i) && t[i]) {
              var o = t[i]
              o = 'Array' === n.util.type(o) ? o : [o]
              for (var s = 0; s < o.length; ++s) {
                var u = o[s],
                  c = u.inside,
                  g = !!u.lookbehind,
                  h = !!u.greedy,
                  f = 0,
                  d = u.alias
                u = u.pattern || u
                for (var p = 0; p < r.length; p++) {
                  var m = r[p]
                  if (r.length > e.length) break e
                  if (!(m instanceof a)) {
                    u.lastIndex = 0
                    var y = u.exec(m),
                      v = 1
                    if (!y && h && p != r.length - 1) {
                      var b = r[p + 1].matchedStr || r[p + 1],
                        k = m + b
                      if (
                        (p < r.length - 2 &&
                          (k += r[p + 2].matchedStr || r[p + 2]),
                        (u.lastIndex = 0),
                        (y = u.exec(k)),
                        !y)
                      )
                        continue
                      var w = y.index + (g ? y[1].length : 0)
                      if (w >= m.length) continue
                      var _ = y.index + y[0].length,
                        P = m.length + b.length
                      if (((v = 3), P >= _)) {
                        if (r[p + 1].greedy) continue
                        ;(v = 2), (k = k.slice(0, P))
                      }
                      m = k
                    }
                    if (y) {
                      g && (f = y[1].length)
                      var w = y.index + f,
                        y = y[0].slice(f),
                        _ = w + y.length,
                        S = m.slice(0, w),
                        O = m.slice(_),
                        j = [p, v]
                      S && j.push(S)
                      var A = new a(i, c ? n.tokenize(y, c) : y, d, y, h)
                      j.push(A),
                        O && j.push(O),
                        Array.prototype.splice.apply(r, j)
                    }
                  }
                }
              }
            }
          return r
        },
        hooks: {
          all: {},
          add: function (e, t) {
            var a = n.hooks.all
            ;(a[e] = a[e] || []), a[e].push(t)
          },
          run: function (e, t) {
            var a = n.hooks.all[e]
            if (a && a.length) for (var r, l = 0; (r = a[l++]); ) r(t)
          }
        }
      }),
      a = (n.Token = function (e, t, n, a, r) {
        ;(this.type = e),
          (this.content = t),
          (this.alias = n),
          (this.matchedStr = a || null),
          (this.greedy = !!r)
      })
    if (
      ((a.stringify = function (e, t, r) {
        if ('string' == typeof e) return e
        if ('Array' === n.util.type(e))
          return e
            .map(function (n) {
              return a.stringify(n, t, e)
            })
            .join('')
        var l = {
          type: e.type,
          content: a.stringify(e.content, t, r),
          tag: 'span',
          classes: ['token', e.type],
          attributes: {},
          language: t,
          parent: r
        }
        if (
          ('comment' == l.type && (l.attributes.spellcheck = 'true'), e.alias)
        ) {
          var i = 'Array' === n.util.type(e.alias) ? e.alias : [e.alias]
          Array.prototype.push.apply(l.classes, i)
        }
        n.hooks.run('wrap', l)
        var o = ''
        for (var s in l.attributes)
          o += (o ? ' ' : '') + s + '="' + (l.attributes[s] || '') + '"'
        return (
          '<' +
          l.tag +
          ' class="' +
          l.classes.join(' ') +
          '" ' +
          o +
          '>' +
          l.content +
          '</' +
          l.tag +
          '>'
        )
      }),
      !_self.document)
    )
      return _self.addEventListener
        ? (_self.addEventListener(
            'message',
            function (e) {
              var t = JSON.parse(e.data),
                a = t.language,
                r = t.code,
                l = t.immediateClose
              _self.postMessage(n.highlight(r, n.languages[a], a)),
                l && _self.close()
            },
            !1
          ),
          _self.Prism)
        : _self.Prism
    var r =
      document.currentScript ||
      [].slice.call(document.getElementsByTagName('script')).pop()
    return (
      r &&
        ((n.filename = r.src),
        document.addEventListener &&
          !r.hasAttribute('data-manual') &&
          document.addEventListener('DOMContentLoaded', n.highlightAll)),
      _self.Prism
    )
  })()
'undefined' != typeof module && module.exports && (module.exports = Prism),
  'undefined' != typeof global && (global.Prism = Prism)
;(Prism.languages.markup = {
  comment: /<!--[\w\W]*?-->/,
  prolog: /<\?[\w\W]+?\?>/,
  doctype: /<!DOCTYPE[\w\W]+?>/,
  cdata: /<!\[CDATA\[[\w\W]*?]]>/i,
  tag: {
    pattern: /<\/?(?!\d)[^\s>\/=.$<]+(?:\s+[^\s>\/=]+(?:=(?:("|')(?:\\\1|\\?(?!\1)[\w\W])*\1|[^\s'">=]+))?)*\s*\/?>/i,
    inside: {
      tag: {
        pattern: /^<\/?[^\s>\/]+/i,
        inside: { punctuation: /^<\/?/, namespace: /^[^\s>\/:]+:/ }
      },
      'attr-value': {
        pattern: /=(?:('|")[\w\W]*?(\1)|[^\s>]+)/i,
        inside: { punctuation: /[=>"']/ }
      },
      punctuation: /\/?>/,
      'attr-name': {
        pattern: /[^\s>\/]+/,
        inside: { namespace: /^[^\s>\/:]+:/ }
      }
    }
  },
  entity: /&#?[\da-z]{1,8};/i
}),
  Prism.hooks.add('wrap', function (a) {
    'entity' === a.type &&
      (a.attributes.title = a.content.replace(/&amp;/, '&'))
  }),
  (Prism.languages.xml = Prism.languages.markup),
  (Prism.languages.html = Prism.languages.markup),
  (Prism.languages.mathml = Prism.languages.markup),
  (Prism.languages.svg = Prism.languages.markup)
