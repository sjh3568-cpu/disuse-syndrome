# CLAUDE.md

이 파일은 Claude Code(claude.ai/code)가 이 저장소에서 작업할 때 참고하는 설명서입니다.
## 프로젝트 목적
 인덕의료재단 전 직원이 비사용증후군을 제대로 이해하고 가족, 지인, 친구들에게 설명 할 수 있을 정도로 교육으로 무장 될 수 있도록 하기 위함
 
## 프로젝트 실행

빌드 과정 없음. 순수 정적 사이트(HTML/CSS/JS)입니다.

- **브라우저:** HTML 파일을 브라우저에서 바로 열면 됨
- **로컬 서버:** `python -m http.server 8000` 실행 후 `http://localhost:8000` 접속
- **PHP 기능:** `save.php`(구형 로컬 저장 방식)는 PHP 서버 필요(`php -S localhost:8000`), 현재는 JSONBin API를 사용하므로 거의 쓰이지 않음

## 구조

한국 병원 직원 대상 모바일 우선 정적 웹앱:

```
index.html          ← 메인 메뉴
├── flashcard.html  ← 플래시카드 학습 (10장)
├── quiz.html       ← 객관식 퀴즈 (10문제)
└── admin.html      ← 비밀번호 보호 관리자 대시보드
```

모든 JS와 CSS는 각 HTML 파일 안에 **인라인**으로 작성되어 있음 — 별도 `.js` / `.css` 파일 없음.

## 데이터 흐름

1. **quiz.html** — 퀴즈 완료 시 결과를 JSONBin API(클라우드 JSON 저장소)에 POST
2. **admin.html** — 같은 JSONBin 저장소에서 GET하여 통계 및 응답자 데이터 표시
3. **save.php / data/results.json** — 구형 백업 방식, 현재 UI에서는 사용 안 함

JSONBin 인증 정보(`JSONBIN_ID`, `JSONBIN_KEY`)와 관리자 비밀번호(`ADMIN_PW`)는 `quiz.html`과 `admin.html`에 JS 상수로 하드코딩되어 있음.

## 주요 구현 사항

- **플래시카드:** 10개 Q&A 카드, CSS 3D 뒤집기 애니메이션, 알았어요/모르겠어요 표시, 진행 상황 메모리 내 추적
- **퀴즈:** 매 로드 시 문제와 보기를 무작위 섞음, 완료 후 점수·이름·부서를 JSONBin에 저장
- **관리자 대시보드:** JSONBin 전체 데이터 불러와 평균 계산, 문제별 정답률 막대 그래프, 부서별 통계, 삭제 기능(JSONBin PUT 호출)
- **폰트:** `'Apple SD Gothic Neo', 'Noto Sans KR', sans-serif` — 한국어 최적화
- **색상 테마:** 페이지마다 다른 그라데이션 — index(짙은 파랑), flashcard(보라), quiz(청록/초록), admin(밝은 회색)
