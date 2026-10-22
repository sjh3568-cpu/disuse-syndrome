# vendor — 화면이 쓰는 외부 라이브러리 로컬 사본 (KIT-02, 2026-10-22)

CDN 대신 이 파일을 쓴다. 버전은 파일 이름에 고정. 새로 받을 때는 같은 URL·버전으로 받고 sha256을 다시 적는다.

| 파일 | 라이브러리·버전 | 라이선스 | 받은 곳 | sha256 |
|---|---|---|---|---|
| qrcode-1.0.0.min.js | qrcodejs 1.0.0 (github.com/davidshimjs/qrcodejs) | MIT (cdnjs 등록 정보 — 파일 안에는 표기 없음) | https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js | c541ef06327885a8415bca8df6071e14189b4855336def4f36db54bde8484f36 |

- 카카오 SDK(`t1.kakaocdn.net/kakao_js_sdk/2.7.2`)·Google 태그는 외부 서비스 연동 스크립트라 그대로 둔다(로컬 사본으로 바꿀 대상 아님).
